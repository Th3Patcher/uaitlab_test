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
        Schema::create('technical_conclusions', function (Blueprint $table) {
            $table->string('code_1c', 36);
            $table->string('number_1c', 25);
            $table->dateTime('date');
            $table->string('defect_codes_code_1c', 36);
            $table->text('conclusion')->nullable();
            $table->text('resolution')->nullable();
            $table->string('symptom_codes_code_1c', 36);
            $table->string('warranty_claims_code_1c', 36);
            $table->string('appeal_type', 20)->nullable();

            $table->unique('warranty_claims_code_1c', 'technical_conclusions_pk');

            $table->foreign('warranty_claims_code_1c')
                ->references('code_1c')->on('warranty_claims')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technical_conclusions');
    }
};
