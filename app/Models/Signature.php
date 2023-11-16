<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    protected $fillable = [
        'status',
        'user_id',
        'product_id',
        'expiration',
    ];

}
