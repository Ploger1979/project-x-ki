<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunde extends Model
{
    protected $table = 'kunden'; 
    protected $fillable = ['name', 'email'];
}