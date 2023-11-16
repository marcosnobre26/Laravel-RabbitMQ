<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchEmail extends Model
{
    use HasFactory;

    protected $table = 'dispatch_mails';

    protected $fillable = [
        'status',
        'email',
        'template_id'
    ];

}
