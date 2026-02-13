<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
               $table->string('phone')->after('email')->default('');
        $table->string('referral_code')->nullable()->after('phone')->default(''); // entered code
        $table->string('my_referral_code')->unique()->after('referral_code')->default(''); // user’s own code
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            
        });
    }
};
