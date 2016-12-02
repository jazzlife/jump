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

            $table->bigInteger('id')->unsigned()->primary();

            $table->bigInteger('entity_id')->index()->unsigned();
            $table->string('entity_type')->index();
            $table->string('name')->index();
            $table->string('type')->nullable();
            $table->text('value')->nullable();

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
