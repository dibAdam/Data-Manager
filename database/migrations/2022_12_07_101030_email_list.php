<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmailList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('pgsql')->create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false)->unique();
            $table->string('domain')->nullable(false);
            $table->integer('isp_id')->nullable(true)->foreign('isp_id')->references('isp_id')->on('ISP');
            $table->integer('geo_id')->nullable(false)->foreign('geo_id')->references('geo_id')->on('GEO');
            $table->string('list_id')->nullable(false);
            $table->string('mx')->nullable(true);
            $table->integer('mbr')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
