<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('client', function (Blueprint $table) {
      $table->id();
      $table->string('fullname');
      $table->string('email')->unique();
      $table->timestamp('date')->nullable();
      $table->string('purok');
      $table->string('metersnumber');
      $table->string('password');
      $table->rememberToken();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('client');
  }
};
