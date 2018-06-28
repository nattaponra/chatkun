<?php


namespace nattaponra\chatkun;


trait HasChatKun
{

    private function initChatKun($chatKun)
    {
        $chatKun->create([
            'user_id'     => $this->id,
            'last_online' => date("Y-m-d H:i:s")
        ]);
    }

    public function chat()
    {
        $chatKun = $this->hasOne(ChatKun::class, "user_id", "id");

        if ($chatKun->count() == 0) {
            $this->initChatKun($chatKun);
            $chatKun = $this->hasOne(ChatKun::class , "user_id", "id");
        }
        return $chatKun;
    }
}