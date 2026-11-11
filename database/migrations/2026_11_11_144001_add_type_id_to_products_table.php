<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'type_id')) {
                $table->foreignId('type_id')
                    ->nullable()
                    ->after('category_id')
                    ->constrained('types')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'type_id')) {
                $table->dropConstrainedForeignId('type_id');
            }
        });
    }
};

