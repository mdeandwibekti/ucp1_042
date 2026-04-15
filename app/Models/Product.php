<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'title',
        'description',
        'price',
        'stock',
        'user_id',
    ];

    /**
     * attributes
     *
     * @var array
     */
    protected $attributes = [
        'description' => '',
        'image' => null,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
