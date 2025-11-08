<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('setting_group_id');
            $table->foreign('setting_group_id')->references('id')->on('setting_groups');

            $table->string('label');
            $table->string('type')->default('text');
            $table->string('name');
            $table->text('value')->nullable();
            $table->text('default_value')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
