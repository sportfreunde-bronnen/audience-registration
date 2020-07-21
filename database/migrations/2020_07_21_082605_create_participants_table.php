<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id')->nullable(false);
            $table->string('secret')->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->string('email')->nullable(true);
            $table->string('phone')->nullable(true);
            $table->integer('amount')->nullable(false)->default(1);
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
        Schema::dropIfExists('participants');
    }
}
