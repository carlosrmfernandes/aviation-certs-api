<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('approvingAuthority')->default('FAA');
            $table->string('approvingCountry')->default('United States');
            $table->string('formTrackingNumber');
            $table->string('organizationName');
            $table->string('organizationAddress')->nullable();
            $table->string('workOrderContractInvoiceNumber')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('conformityApprovedDesign')->default(false);
            $table->boolean('conformityNonApprovedDesign')->default(false);
            $table->boolean('returnToService')->default(false);
            $table->boolean('otherRegulation')->default(false);
            $table->string('authorizedSignature13')->nullable();
            $table->string('approvalAuthorizationNo')->nullable();
            $table->string('authorizedSignature14')->nullable();
            $table->string('approvalCertificateNo')->nullable();
            $table->string('name13')->nullable();
            $table->string('date13')->nullable();
            $table->string('name14')->nullable();
            $table->string('date14')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
