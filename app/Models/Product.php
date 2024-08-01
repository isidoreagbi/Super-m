<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category_id',
        'price',
        'image',
        'quantity',
        'short_description',
        'long_description',
        'short_description',
    ];

    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }
}
