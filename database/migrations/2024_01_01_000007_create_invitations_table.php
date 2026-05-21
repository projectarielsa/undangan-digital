<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->nullable()->constrained('invitation_templates')->nullOnDelete();
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('groom_name');
            $table->string('groom_father')->nullable();
            $table->string('groom_mother')->nullable();
            $table->string('groom_photo')->nullable();
            $table->text('groom_bio')->nullable();
            $table->string('groom_instagram')->nullable();
            $table->string('bride_name');
            $table->string('bride_father')->nullable();
            $table->string('bride_mother')->nullable();
            $table->string('bride_photo')->nullable();
            $table->text('bride_bio')->nullable();
            $table->string('bride_instagram')->nullable();
            $table->date('event_date');
            $table->time('event_time_start');
            $table->time('event_time_end')->nullable();
            $table->string('event_venue');
            $table->text('event_address')->nullable();
            $table->string('event_maps_url')->nullable();
            $table->decimal('event_latitude', 10, 7)->nullable();
            $table->decimal('event_longitude', 10, 7)->nullable();
            $table->date('reception_date')->nullable();
            $table->time('reception_time_start')->nullable();
            $table->time('reception_time_end')->nullable();
            $table->string('reception_venue')->nullable();
            $table->text('reception_address')->nullable();
            $table->string('reception_maps_url')->nullable();
            $table->text('opening_text')->nullable();
            $table->text('closing_text')->nullable();
            $table->text('love_story')->nullable();
            $table->string('dress_code')->nullable();
            $table->text('gift_info')->nullable();
            $table->string('qris_image')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('music_url')->nullable();
            $table->boolean('music_autoplay')->default(true);
            $table->string('color_primary')->nullable();
            $table->string('color_secondary')->nullable();
            $table->string('font_heading')->nullable();
            $table->string('font_body')->nullable();
            $table->enum('status', ['draft', 'published', 'paused', 'expired'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->unsignedBigInteger('view_count')->default(0);
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'status']);
            $table->index('event_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
