<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;

    protected $table = 'products';
    protected $guarded = [];

    public function toSearchableArray()
    {
        return $this->toArray();
    }
}
