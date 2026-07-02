<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table("guests", function (Blueprint $table) {
            $table->index("invitation_id");
            $table->index("rsvp_status");
        });

        Schema::table("guestbooks", function (Blueprint $table) {
            $table->index("invitation_id");
            $table->index("is_approved");
        });
    }

    public function down(): void
    {
        Schema::table("guests", function (Blueprint $table) {
            $table->dropIndex(["invitation_id"]);
            $table->dropIndex(["rsvp_status"]);
        });

        Schema::table("guestbooks", function (Blueprint $table) {
            $table->dropIndex(["invitation_id"]);
            $table->dropIndex(["is_approved"]);
        });
    }
};
