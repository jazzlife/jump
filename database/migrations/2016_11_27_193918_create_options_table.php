<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('entity_id')->index()->unsigned();
            $table->string('entity_type')->index();
            $table->string('name')->index();
            $table->string('type')->nullable();
            $table->text('value');

            $table->timestamps();

            $table->unique(['entity_id', 'name']);

            $table->foreign('entity_id')
                  ->references('id')
                  ->on('entities')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
    }
}
