<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('offer18_partner_id')->nullable()->after('partner_reference');
            $table->string('offer18_partner_type')->nullable()->after('offer18_partner_id');
            $table->string('offer18_sync_status')->nullable()->after('offer18_partner_type');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['offer18_partner_id', 'offer18_partner_type', 'offer18_sync_status']);
        });
    }
};
