<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->string('phone')->after('name');
            $table->string('email')->after('phone');
            $table->text('address')->after('email');
            $table->string('city')->after('address');
            $table->string('state')->after('city');
            $table->string('pincode')->after('state');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'phone',
                'email',
                'address',
                'city',
                'state',
                'pincode'
            ]);
        });
    }
};
