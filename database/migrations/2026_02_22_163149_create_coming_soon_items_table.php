<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coming_soon_items', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->enum('type',['product','meeting','seminar','place']);

            $table->text('description')->nullable();

            $table->string('image')->nullable();

            $table->date('launch_date')->nullable();

            $table->string('location')->nullable();

            $table->enum('status',['active','inactive'])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coming_soon_items');
    }
};