<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('amount', 10, 2)->default(0);

            $table->string('description');

            $table->date('paid_at')->nullable();

            $table->date('due_date')->nullable(); // not currently used, but can be used in the future to track due dates for debts
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
