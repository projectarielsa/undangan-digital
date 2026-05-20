<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('device_type', 20)->nullable(); // mobile, tablet, desktop
            $table->string('browser', 50)->nullable();
            $table->string('os', 50)->nullable();
            $table->string('referrer')->nullable();
            $table->string('country', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->foreignId('guest_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('viewed_at');
            $table->index(['invitation_id', 'viewed_at']);
            $table->index(['invitation_id', 'device_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_views');
    }
};
