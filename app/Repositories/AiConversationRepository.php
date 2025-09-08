<?php 

namespace App\Repositories;

use App\Models\AiConversation;

class AiConversationRepository extends BaseRepository
{
    public function modelName(): string
    {
        return AiConversation::class;
    }
}