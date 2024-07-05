<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shorten extends Model {
    use HasFactory;

    protected $fillable = ['original_url', 'normalized_url',  'hash'];
}
