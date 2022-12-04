<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcelles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('proprietaire_id')->constrained('proprietaires')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('numero')->unique();
            $table->date('date_delimitation');
            $table->foreignId('village_id')->constrained('villages')->onDelete('cascade')->onUpdate('cascade');
            $table->string('signature');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcelles_name');
    }
};
