<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->json('bank_accounts')->nullable()->after('bank_account_name');
        });

        // Migrate existing single bank data to bank_accounts JSON
        DB::table('invitations')
            ->whereNotNull('bank_name')
            ->orderBy('id')
            ->each(function ($invitation) {
                $accounts = [[
                    'bank_name' => $invitation->bank_name,
                    'account_number' => $invitation->bank_account_number,
                    'account_name' => $invitation->bank_account_name,
                ]];
                DB::table('invitations')
                    ->where('id', $invitation->id)
                    ->update(['bank_accounts' => json_encode($accounts)]);
            });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn('bank_accounts');
        });
    }
};
