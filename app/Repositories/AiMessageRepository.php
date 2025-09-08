<?php

namespace App\Repositories;

use App\Models\AiMessage;

class AiMessageRepository extends BaseRepository
{
    public function modelName(): string
    {
        return AiMessage::class;
    }
}