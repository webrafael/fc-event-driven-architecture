<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'index';

    protected $fillable = [
        'id',
        'account_id_from',
        'account_id_to',
        'amount',
        'created_at',
        'updated_at',
    ];
}
