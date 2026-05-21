<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('discount_price', 12, 2)->nullable();
            $table->integer('duration_days')->default(365);
            $table->integer('max_photos')->default(5);
            $table->integer('max_guests')->default(100);
            $table->integer('max_templates')->default(1);
            $table->boolean('has_rsvp')->default(false);
            $table->boolean('has_music')->default(false);
            $table->boolean('has_guestbook')->default(false);
            $table->boolean('has_gallery')->default(true);
            $table->boolean('has_countdown')->default(true);
            $table->boolean('has_love_story')->default(false);
            $table->boolean('has_digital_envelope')->default(false);
            $table->boolean('has_qr_checkin')->default(false);
            $table->boolean('has_custom_domain')->default(false);
            $table->boolean('has_analytics')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->json('features')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
