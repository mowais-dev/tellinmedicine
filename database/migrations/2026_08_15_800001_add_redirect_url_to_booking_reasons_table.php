<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_reasons', function (Blueprint $table) {
            $table->string('redirect_url')->nullable()->after('value');
        });
    }

    public function down(): void
    {
        Schema::table('booking_reasons', function (Blueprint $table) {
            $table->dropColumn('redirect_url');
        });
    }
};
