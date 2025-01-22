<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(){
        
        Schema::table('translations', function (Blueprint $table) {
            $table->index('locale');
            $table->index('key');
            $table->index('tags');
        });
    }

    public function down(){

        Schema::table('translations', function (Blueprint $table) {
            $table->dropIndex(['locale']);
            $table->dropIndex(['key']);
            $table->dropIndex(['tags']);
        });
    }
};
