<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateChatKunMessageTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create("chatkun_messages", function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();
            $table->string("message_type");
            $table->text("message");
            $table->integer("user_id")->index();
            $table->integer("room_id")->index();

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop("chatkun_messages");
    }
}