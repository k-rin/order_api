<?php

namespace App\Models;

use App\Traits\BindsDynamically;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCur extends Model
{
    use HasFactory, BindsDynamically;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'bnb_id',
        'price',
    ];
}
