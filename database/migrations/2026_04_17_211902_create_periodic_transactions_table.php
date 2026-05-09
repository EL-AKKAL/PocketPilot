<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periodic_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2)->default(0);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('frequency')->default('daily');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('next_apply_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periodic_transactions');
    }
};
