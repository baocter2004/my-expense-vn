<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Ai\AiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    public function __construct(protected AiService $aiService) {}
    public function query(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'conversation_id' => 'nullable|integer'
        ]);

        $userId = $request->input('user_id');
        $message = $request->input('message');
        $conversationId = $request->input('conversation_id');

        $result = $this->aiService->handleUserQuery($userId, $conversationId, $message);

        Log::info("hehe",[$result]);

        return response()->json([
            'ok' => true,
            'data' => $result
        ]);
    }
}
