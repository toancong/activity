<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivitiesCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('content')->nullable();
            $table->string('summary')->nullable();
            $table->json('actor');
            $table->unsignedInteger('actor_id')->index();
            $table->string('actor_type', 10)->index();
            $table->string('type')->index();
            $table->json('object');
            $table->unsignedInteger('object_id')->index();
            $table->string('object_type')->index();
            $table->json('target')->nullable();
            $table->unsignedInteger('target_id')->nullable()->index();
            $table->string('target_type')->nullable()->index();
            $table->json('meta')->nullable();
            $table->dateTime('published')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('activities');
    }
}
