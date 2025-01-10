<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->timestamps();
        });

        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('license_key')->unique();
            $table->enum('type', ['single', 'multiple']);
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->enum('status', ['active', 'expired', 'suspended'])->default('active');
            $table->timestamps();
        });

        Schema::create('license_domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('license_id')->constrained()->onDelete('cascade');
            $table->string('domain');
            $table->timestamps();

            $table->unique(['license_id', 'domain']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('license_domains');
        Schema::dropIfExists('licenses');
        Schema::dropIfExists('customers');
    }
};