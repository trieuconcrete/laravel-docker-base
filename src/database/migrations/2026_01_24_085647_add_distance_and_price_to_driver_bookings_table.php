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
        Schema::table('driver_bookings', function (Blueprint $table) {
            $table->decimal('distance', 8, 2)->nullable()->after('dropoff_location'); // Distance in km
            $table->decimal('price', 10, 2)->nullable()->after('distance'); // Price in VND
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('driver_bookings', function (Blueprint $table) {
            $table->dropColumn(['distance', 'price']);
        });
    }
};
