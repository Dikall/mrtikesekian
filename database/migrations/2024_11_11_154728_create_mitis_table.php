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
        Schema::create('mitis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade'); // Foreign key to risks
            $table->string('mitigasi');  
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitis');
    }
};
