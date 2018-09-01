<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateChatKunMessageStatusTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create("chatkun_message_statuses", function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();
            $table->string("message_id")->index();
            $table->integer("user_id")->index();
            $table->string("status")->index();

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop("chatkun_message_statuses");
    }
}