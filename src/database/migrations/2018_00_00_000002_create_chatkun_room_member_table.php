<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateChatkunRoomMemberTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create("chatkun_room_members", function (Blueprint $table) {

            $table->increments('id');
            $table->integer('room_id')->index();
            $table->integer('user_id')->index();
            $table->string('role')->nullable()->index();
            $table->timestamps();

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop("chatkun_room_members");
    }
}