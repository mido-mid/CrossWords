<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename');
            $table->biginteger('user_id')->unsigned();
            $table->biginteger('translator_id')->nullable()->unsigned();
            $table->foreignId('source_language')->constrained('languages');
            $table->foreignId('target_language')->constrained('languages');
            $table->integer('words');
            $table->integer('total_price');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('translator_id')->references('id')->on('translators');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_files');
    }
}
