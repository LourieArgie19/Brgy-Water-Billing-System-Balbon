<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('billing', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('client_id');
      $table->string('transaction_id');
      $table->string('previous_reading');
      $table->string('current_reading');
      $table->string('price');
      $table->date('date_issued')->useCurrent();
      $table->date('date_of_payment')->nullable();
      $table->boolean('is_paid')->default(false);
      $table->timestamps();

      $table
        ->foreign('client_id')
        ->references('id')
        ->on('client')
        ->onDelete('cascade')
        ->onUpdate('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('billing');
  }
};
