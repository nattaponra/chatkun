<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateChatKunTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create("chatkun", function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->dateTime("last_online");
            $table->timestamps();

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop("chatkun");
    }
}