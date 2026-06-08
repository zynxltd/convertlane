<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('company_number')->nullable()->after('company');
            $table->string('incorporation_country', 2)->nullable()->after('country');
            $table->date('incorporated_at')->nullable();
            $table->string('dd_status')->default('applied')->after('status');
            $table->string('partner_reference')->nullable()->unique();
        });

        Schema::create('due_diligence_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->string('partner_reference');
            $table->string('type'); // publisher | advertiser

            $table->string('status')->default('applied');
            $table->string('risk_band')->nullable();
            $table->unsignedSmallInteger('risk_score')->nullable();

            $table->boolean('documents_complete')->default(false);
            $table->timestamp('documents_requested_at')->nullable();
            $table->timestamp('documents_deadline_at')->nullable();
            $table->timestamp('pack_received_at')->nullable();

            $table->boolean('sanctions_clear')->nullable();
            $table->timestamp('sanctions_checked_at')->nullable();
            $table->boolean('pep_clear')->nullable();
            $table->boolean('finance_approved')->nullable();
            $table->string('finance_approved_by')->nullable();
            $table->decimal('exposure_limit_gbp', 12, 2)->nullable();
            $table->string('payment_terms')->nullable();

            $table->boolean('compliance_signed_off')->default(false);
            $table->string('compliance_signed_by')->nullable();
            $table->timestamp('compliance_signed_at')->nullable();

            $table->boolean('am_signed_off')->default(false);
            $table->string('am_signed_by')->nullable();
            $table->timestamp('am_signed_at')->nullable();

            $table->string('affise_partner_id')->nullable();
            $table->string('rejection_code')->nullable();
            $table->text('rejection_notes')->nullable();
            $table->text('internal_notes')->nullable();
            $table->json('checklist_snapshot')->nullable();

            $table->timestamps();
        });

        Schema::create('due_diligence_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('due_diligence_review_id')->constrained()->cascadeOnDelete();
            $table->string('actor')->nullable();
            $table->string('from_status')->nullable();
            $table->string('to_status');
            $table->text('notes')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('due_diligence_audit_logs');
        Schema::dropIfExists('due_diligence_reviews');

        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'company_number',
                'incorporation_country',
                'incorporated_at',
                'dd_status',
                'partner_reference',
            ]);
        });
    }
};
