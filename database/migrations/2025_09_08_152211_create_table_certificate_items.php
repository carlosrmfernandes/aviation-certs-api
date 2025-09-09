<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('certificate_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_id')->constrained()->onDelete('cascade');
            $table->string('item');
            $table->string('description');
            $table->string('partNumber');
            $table->string('quantity');
            $table->string('serialNumber')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('certificate_items');
    }
};
