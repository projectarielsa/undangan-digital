<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Adds 'invited_by' field to guests table.
     * This allows each guest to have a different person inviting them,
     * displayed as "Turut Mengundang: Bapak/Ibu XXX" on the invitation.
     */
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->string('invited_by')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn('invited_by');
        });
    }
};
