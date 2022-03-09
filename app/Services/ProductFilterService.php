<?php

namespace App\Services;

use App\Models\Product;
use Carbon\Carbon;

class ProductFilterService
{
    /**
     * Get all products
     * Filtering supported
     *
     * @param array $filters supported keys: name, author_name, date
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public static function productsFiltered($keyword): \Illuminate\Database\Eloquent\Collection|array
    {
        $products = Product::query();

        $products->when(!is_null($keyword), function ($query) use ($keyword){

            if (\DateTime::createFromFormat('Y-m-d', $keyword)) {
                $currentDay = Carbon::createFromFormat('Y-m-d H:i:s', $keyword . '00:00:00')->toDateTimeString();

                $query->whereDate('created_at', '=', $currentDay);
            } else {
                $query->where('author_name', 'LIKE', "%$keyword%")
                    ->orWhere('name', 'LIKE', "%$keyword%");
            }
        });

        return $products->get();
    }
}