<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partner_agreements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('due_diligence_review_id')->constrained()->cascadeOnDelete();
            $table->string('partner_reference');
            $table->string('type'); // publisher | advertiser
            $table->string('agreement_version', 32)->default('2026-01');
            $table->json('questionnaire_snapshot');
            $table->longText('agreement_body');
            $table->string('signer_name');
            $table->string('signer_title')->nullable();
            $table->longText('signature_image');
            $table->string('billing_model')->nullable(); // prepay | postpay (advertisers)
            $table->string('signed_ip', 45)->nullable();
            $table->text('signed_user_agent')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamps();

            $table->unique('due_diligence_review_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_agreements');
    }
};
