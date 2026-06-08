<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('brand');
            $table->string('brand_slug')->nullable();
            $table->boolean('in_house')->default(false);
            $table->string('vertical');
            $table->string('model');
            $table->string('payout');
            $table->string('event');
            $table->json('geos');
            $table->json('traffic')->nullable();
            $table->string('cap')->nullable();
            $table->string('status')->default('live');
            $table->string('epc_hint')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_published')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
