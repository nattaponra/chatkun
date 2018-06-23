<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateChatKunSubMessageTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create("chatkun_sub_messages", function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger("messages_id")->index();
            $table->string("sub_message_type")->index();
            $table->text("message");
            $table->timestamps();
            $table->foreign('messages_id') ->references('id')->on('chatkun_messages')->onDelete('cascade');


        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop("chatkun_sub_messages");
    }
}