<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanelMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panel_menus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('statu')->default(true);
            $table->boolean('meta')->default(false);
            $table->boolean('editor')->default(false);
            $table->boolean('multiple_image')->default(false);
            $table->boolean('image')->default(false);
            $table->boolean('categories')->default(false);
            $table->json('extra')->nullable();
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
        Schema::dropIfExists('panel_menus');
    }
}
