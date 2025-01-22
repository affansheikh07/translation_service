<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(){

    Schema::create('translations', function (Blueprint $table) {
        $table->id();
        $table->string('locale');
        $table->string('key')->unique();
        $table->text('content');
        $table->json('tags')->nullable();
        $table->timestamps();

        $table->index(['locale', 'key']);
    });

    }

    
    public function down(){
        
        Schema::dropIfExists('translations');
    }
};
