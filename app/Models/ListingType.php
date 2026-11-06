<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListingType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function houses(): HasMany
    {
        return $this->hasMany(House::class);
    }
}