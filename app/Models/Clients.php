<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
  use HasFactory;

  protected $table = 'client';
  protected $fillable = ['user_id', 'purok', 'meter_number', 'date'];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function bills()
  {
    return $this->hasMany(Billing::class, 'client_id');
  }
}
