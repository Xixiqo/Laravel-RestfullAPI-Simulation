<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Jika nama tabel tidak standar, bisa di-define:
    // protected $table = 'products';

    // Mass assignable attributes
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];
}