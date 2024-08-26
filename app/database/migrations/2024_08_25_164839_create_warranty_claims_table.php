<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warranty_claims', function (Blueprint $table) {
            $table->string('code_1c', 36)->unique();
            $table->string('number_1c', 30)->primary();
            $table->dateTime('date');
            $table->dateTime('date_of_claim');
            $table->dateTime('date_of_sale');
            $table->string('factory_number', 30)->nullable();
            $table->text('comment')->nullable();
            $table->string('point_of_sale', 250)->nullable();
            $table->string('product_name', 250)->nullable();
            $table->text('details');
            $table->string('manager', 250);
            $table->string('autor', 250);
            $table->string('client_name', 250)->nullable();
            $table->string('sender_name', 250)->nullable();
            $table->bigInteger('client_phone');
            $table->bigInteger('sender_phone');
            $table->string('type_of_claim', 100)->nullable();
            $table->string('receipt_number', 250)->nullable();
            $table->bigInteger('service_partner');
            $table->integer('service_contract')->nullable();
            $table->integer('product_article');
            $table->string('status', 50);
            $table->float('spare_parts_sum', 10, 2);
            $table->float('service_works_sum', 10, 2);

            $table->unique('code_1c', 'warranty_claims_pk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranty_claims');
    }
};
