<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('navigation_items', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('url');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_cta')->default(false);
            $table->string('care_model')->nullable();
            $table->timestamps();
        });

        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('page')->unique(); // home, education, philosophy
            $table->string('badge')->nullable();
            $table->text('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('image_path')->nullable();
            $table->string('primary_button_text')->nullable();
            $table->string('primary_button_url')->nullable();
            $table->string('primary_button_model')->nullable();
            $table->string('secondary_button_text')->nullable();
            $table->string('secondary_button_url')->nullable();
            $table->string('secondary_button_model')->nullable();
            $table->string('badge1_title')->nullable();
            $table->string('badge1_sub')->nullable();
            $table->string('badge2_title')->nullable();
            $table->string('badge2_sub')->nullable();
            $table->timestamps();
        });

        Schema::create('pillars', function (Blueprint $table) {
            $table->id();
            $table->string('page')->default('home'); // home, philosophy
            $table->string('icon')->nullable();
            $table->string('image_path')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('link_text')->nullable();
            $table->string('link_url')->nullable();
            $table->string('care_model')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->nullable();
            $table->string('name');
            $table->string('credentials')->nullable();
            $table->text('quote')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamps();
        });

        Schema::create('doctor_timelines', function (Blueprint $table) {
            $table->id();
            $table->string('year_range');
            $table->string('title');
            $table->text('description');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('category')->default('primary'); // primary, home, telehealth, certs
            $table->string('icon')->nullable();
            $table->string('title');
            $table->text('description');
            $table->json('features')->nullable();
            $table->string('button_text')->nullable();
            $table->string('care_model')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('education_guides', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('icon_bg')->nullable();
            $table->string('title');
            $table->text('description');
            $table->json('features')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('preventive_checklists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('border_color')->default('#1A84C5');
            $table->json('items')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('philosophy_contents', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('title');
            $table->text('highlight_quote');
            $table->text('paragraph1');
            $table->text('paragraph2');
            $table->string('cta_title')->nullable();
            $table->text('cta_text')->nullable();
            $table->string('cta_phone_text')->nullable();
            $table->string('cta_phone_url')->nullable();
            $table->string('cta_form_text')->nullable();
            $table->timestamps();
        });

        Schema::create('chat_widget_configs', function (Blueprint $table) {
            $table->id();
            $table->string('assistant_name');
            $table->string('status_text');
            $table->text('welcome_message');
            $table->string('input_placeholder');
            $table->timestamps();
        });

        Schema::create('chat_chips', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->text('prompt');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('booking_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('value');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('path');
            $table->string('alt_text')->nullable();
            $table->string('mime_type')->nullable();
            $table->integer('size')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
        Schema::dropIfExists('booking_reasons');
        Schema::dropIfExists('chat_chips');
        Schema::dropIfExists('chat_widget_configs');
        Schema::dropIfExists('philosophy_contents');
        Schema::dropIfExists('preventive_checklists');
        Schema::dropIfExists('education_guides');
        Schema::dropIfExists('services');
        Schema::dropIfExists('doctor_timelines');
        Schema::dropIfExists('doctor_profiles');
        Schema::dropIfExists('pillars');
        Schema::dropIfExists('hero_sections');
        Schema::dropIfExists('navigation_items');
    }
};
