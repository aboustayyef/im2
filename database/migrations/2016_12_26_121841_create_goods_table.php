<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('Code');
            $table->string('Name');
            $table->string('Brand');
            $table->string('Description');
            $table->string('Supplier');
            $table->decimal('PriceEx');
            $table->decimal('PriceIn');
            $table->decimal('Value');
            $table->smallInteger('Stock');
            $table->smallInteger('AddedToInvoice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
}
