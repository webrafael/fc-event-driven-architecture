<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'index';

    protected $fillable = [
        'id',
        'client_id',
        'balance',
        'created_at',
        'updated_at'
    ];
}
