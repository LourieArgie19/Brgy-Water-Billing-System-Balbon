<?php

namespace Database\Seeders;

use App\Models\Billing;
use App\Models\Clients;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $user = User::create([
      'name' => 'argie',
      'email' => 'argiebalbon9+client@gmail.com',
      'password' => bcrypt('argie12345'),
      'usertype' => User::USER_TYPE_CLIENT,
      'email_verified_at' => now(),
    ]);

    $client = Clients::create([
      'user_id' => $user->id,
      'date' => now(),
      'purok' => 'Rizal',
      'meter_number' => '123456789'
    ]);

    Billing::create([
      'client_id' => $client->id,
      'previous_reading' => 0,
      'current_reading' => 100,
      'price' => 100 * env('WATER_RATE'),
      'date_issued' => now()->subMonth(),
      'is_paid' => false
    ]);
  }
}
