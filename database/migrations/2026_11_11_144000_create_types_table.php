<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();

            $table->unique(['category_id', 'name'], 'types_category_id_name_unique');
            $table->index('name', 'types_name_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('types');
    }
};

