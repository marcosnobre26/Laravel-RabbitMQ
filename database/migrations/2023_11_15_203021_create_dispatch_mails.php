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
        Schema::create('dispatch_mails', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(1)->comment('1 = pending/ 2 = sent');
            $table->string('email');
            $table->unsignedBigInteger('template_id'); 
            $table->foreign('template_id')->references('id')->on('templates'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispatch_mails');
    }
};
