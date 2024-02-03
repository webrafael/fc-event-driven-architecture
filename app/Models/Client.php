<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'index';

    protected $fillable = [
        'id',
        'name',
        'email',
        'created_at',
        'updated_at',
    ];
}
