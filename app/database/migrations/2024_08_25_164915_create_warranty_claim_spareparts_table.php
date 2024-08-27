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
        Schema::create('warranty_claim_spareparts', function (Blueprint $table) {
            $table->string('code_1c', 36);
            $table->string('warranty_claims_number_1c', 36);
            $table->integer('line_number');
            $table->string('articul', 50);
            $table->string('product', 250)->nullable();
            $table->integer('qty');
            $table->float('price', 10, 2);
            $table->float('sum', 10, 2);
            $table->integer('discount');

            $table->foreign('warranty_claims_number_1c')
                ->references('number_1c')->on('warranty_claims')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranty_claim_spareparts');
    }
};
