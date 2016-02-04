<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('claimant');
            $table->string('coc');
            $table->string('dm');
            $table->string('policy');
            $table->string('documents');
            $table->text('documents_comments');
            $table->timestamp('encoded');
            $table->double('amount');
            $table->integer('stage');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('infos');
    }
}
