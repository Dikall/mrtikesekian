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
        Schema::create('risks', function (Blueprint $table) {  
            $table->id();  
            $table->string('kode', 4);
            $table->enum('faktor', ['Alam atau Lingkungan', 'Manusia', 'Sistem dan Infrastruktur']);  
            $table->string('kemungkinan');   
            $table->string('dampak');  
            $table->timestamps();  
        });  
    }

    public function down(): void
    {
        Schema::dropIfExists('risks');
    }
};