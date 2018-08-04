<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateChatkunMessageTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create("chatkun_messages", function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("room_id")->index();
            $table->integer("user_id")->index();
            $table->string("message_type");
            $table->text("message_content");
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