<?php

namespace App\Services;

use App\Models\Category;
use App\Models\City;
use App\Models\House;

class HouseService
{
    public function getCategoriesAndCities()
    {
        return [
            'categories' => Category::latest()->get(),
            'cities' => City::latest()->get(),
            'houses' => House::latest()->get(),
        ];
    }

    public function searchHouses(array $filters) : array
    {
        $query = House::query();

        if (!empty($filters['city'])) {
            $query->where('city_id', $filters['city']);
        }

        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (!empty($filters['house'])) {
            $query->where('house_id',$filters['house']);
        }

        $houses = $query->get();

        $category = Category::findOrFail($filters['category'] ?? null);
        $city = City::findOrFail($filters['city'] ?? null);
        $house = House::findOrFail($filters['house'] ?? null);

        return compact('houses', 'category', 'city');
    }

    public function getHouseDetails (House $house)
    {
        $house->load(['photos', 'facilities', 'facilities.facility']);
        return $house;
    }
}
