<?php

namespace App\Services;

use App\Models\Category;
use App\Models\City;
use App\Models\House;
use App\Models\ListingType;

class HouseService
{
    public function getCategoriesAndCities()
    {
        return [
            'categories' => Category::latest()->get(),
            'cities' => City::latest()->get(),
            'houses' => House::latest()->get(),
            'listingtype' => ListingType::latest()->get(),
        ];
    }

    public function searchHouses(array $filters): array
    {
        $query = House::query();

        if (!empty($filters['city'])) {
            $query->where('city_id', $filters['city']);
        }

        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (!empty($filters['listing'])) {
            $query->where('listing_type_id', $filters['listing']);
        }

        $houses = $query->get();

        $category = Category::findOrFail($filters['category'] ?? null);
        $city = City::findOrFail($filters['city'] ?? null);
        $listing = ListingType::findOrFail($filters['listing'] ?? null);


        return compact('houses', 'category', 'city');
    }

    public function getHouseDetails(House $house)
    {
        $house->load(['photos', 'facilities', 'facilities.facility']);
        return $house;
    }
}
