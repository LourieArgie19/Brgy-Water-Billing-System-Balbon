<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
  use HasFactory;

  protected $table = 'client';
  protected $fillable = ['fullname', 'email', 'date', 'purok', 'metersnumber', 'password'];
}
