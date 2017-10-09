<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcSeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hc_seo', function (Blueprint $table) {
            $table->integer('count', true);
            $table->string('id', 36)->unique('id_UNIQUE');
            $table->timestamps();
            $table->softDeletes();
            $table->text('path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hc_seo');
    }
}
