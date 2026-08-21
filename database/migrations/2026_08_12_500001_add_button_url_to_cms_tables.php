<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'button_url')) {
                $table->string('button_url')->nullable()->after('button_text');
            }
        });

        Schema::table('philosophy_contents', function (Blueprint $table) {
            if (!Schema::hasColumn('philosophy_contents', 'cta_form_url')) {
                $table->string('cta_form_url')->nullable()->after('cta_form_text');
            }
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'button_url')) {
                $table->dropColumn('button_url');
            }
        });

        Schema::table('philosophy_contents', function (Blueprint $table) {
            if (Schema::hasColumn('philosophy_contents', 'cta_form_url')) {
                $table->dropColumn('cta_form_url');
            }
        });
    }
};
