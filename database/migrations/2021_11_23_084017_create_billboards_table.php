<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billboards', function (Blueprint $table) {
            $table->id();
            $table->string("img_src")->nullable();
            $table->string("address");
            $table->string("city");
            $table->string("format");
            $table->string("size");
            $table->string("side");
            $table->integer("price");
            $table->integer("mounting");
            $table->integer("printing");
            $table->string("material");
            $table->boolean("spotlight");
            $table->string("tax");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billboards');
    }
}
