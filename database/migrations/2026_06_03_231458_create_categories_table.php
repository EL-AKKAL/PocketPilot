<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('value');

            $table->string('type')->default('income');

            $table->timestamps();

            Schema::table('transactions', function (Blueprint $table) {
                $table->foreignId('category_id')
                    ->nullable()
                    ->after('account_id')
                    ->constrained()
                    ->nullOnDelete();
            });

            Schema::table('periodic_transactions', function (Blueprint $table) {
                $table->foreignId('category_id')
                    ->nullable()
                    ->after('account_id')
                    ->constrained()
                    ->nullOnDelete();
            });

            $table->unique(['account_id', 'value']);
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });

        Schema::table('periodic_transactions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });

        Schema::dropIfExists('categories');
    }
};
