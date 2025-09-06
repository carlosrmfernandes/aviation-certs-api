<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->string('partNumber')->nullable();
            $table->string('serialNumber')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('formNumber')->nullable();
            $table->string('workOrderNumber')->nullable();
            $table->string('quantity')->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->string('approval')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
