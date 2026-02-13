<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // relation with users table
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // total order amount
            $table->decimal('total_amount', 10, 2);

            // payment status: pending, paid, failed
            $table->enum('payment_status', ['pending', 'paid', 'failed'])
                  ->default('pending');

            // order status: pending, processing, completed, cancelled
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])
                  ->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
