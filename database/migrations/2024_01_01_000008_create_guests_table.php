<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('slug')->nullable();
            $table->enum('rsvp_status', ['pending', 'attending', 'not_attending', 'maybe'])->default('pending');
            $table->unsignedTinyInteger('number_of_guests')->default(1);
            $table->text('message')->nullable();
            $table->string('qr_code')->nullable();
            $table->boolean('is_checked_in')->default(false);
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->unsignedInteger('open_count')->default(0);
            $table->timestamps();
            $table->index(['invitation_id', 'rsvp_status']);
            $table->unique(['invitation_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
