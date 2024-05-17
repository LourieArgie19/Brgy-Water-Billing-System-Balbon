<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
  use HasFactory;
  protected $table = 'billing';
  protected $fillable = ['client_id', 'previous_reading', 'current_reading', 'price', 'date_issued', 'is_paid'];

  public function getPrettyStatus()
  {
    // if (!$this->is_paid && Carbon::parse($this->date_issued)->lt(now())) {
    //   return 'Overdue';
    // }
    return $this->is_paid ? 'Paid' : 'Pending';
  }

  public function getCalculatedPrice()
  {
    if (!$this->is_paid && Carbon::parse($this->date_issued)->lt(now())) {
      return $this->price + (Carbon::parse($this->date_issued)->diffInMonths(now()) * 5);
    }
    return $this->price;
  }

  public function billOwner()
  {
    return $this->belongsTo(Clients::class, 'client_id');
  }
}
