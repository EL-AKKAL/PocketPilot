<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->decimal('value', 10, 2);
            $table->string('period');
            $table->string('status')->default('in_progress');

            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
