<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class House extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'thumbnail',
        'category_id',
        'listing_type',
        'name',
        'slug',
        'price',
        'bedroom',
        'bathroom',
        'garage',
        'floors',
        'land_area',
        'building_area',
        'electric',
        'certificate',
        'furnishing',
        'city_id',
        'address',
        'latitude',
        'longitude',
        'about',
        'status',
    ];

    public function Agent()
    {
         return $this->belongsTo(User::class, 'user_id');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function photos()
    {
        return $this->hasMany(HousePhoto::class);
    }

    public function interest()
    {
        return $this->hasMany(Interest::class);
    }

    public function facilities()
    {
        return $this->hasMany(HouseFacility::class, 'house_id');
    }

    public function mortgageRequests()
    {
        return $this->hasMany(MortgageRequest::class);
    }
}
