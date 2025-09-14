<?php

namespace App\Services\Ai;

use App\Consts\TransactionConst;
use App\Services\Client\AiConversationService;
use App\Services\Client\AiMessageService;
use App\Services\Client\CategoryService;
use App\Services\Client\ContactService;
use App\Services\Client\TransactionService;
use App\Services\Client\UserService;
use App\Services\Client\WalletService;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiService
{
    protected string $endpoint;
    protected ?string $token;
    protected ?string $model;

    public function __construct(
        protected TransactionService $transactionService,
        protected WalletService $walletService,
        protected CategoryService $categoryService,
        protected AiMessageService $aiMessageService,
        protected AiConversationService $aiConversationService,
        protected ContactService $contactService,
        protected UserService $userService
    ) {
        $this->endpoint = config('services.gemini.endpoint');
        $this->token = config('services.gemini.token');
        $this->model = config('services.gemini.model');
    }

    /** ================= Gemini ================= */

    public function generateContent(string $textPrompt, array $options = [], ?string $bearerToken = null): array
    {
        if (empty($this->endpoint) || empty($this->model)) {
            throw new Exception('GEMINI_ENDPOINT or GEMINI_MODEL not configured.');
        }

        $url = rtrim($this->endpoint) . "/v1beta/models/" . rtrim($this->model) . ":generateContent";

        $payload = [
            'contents' => [
                [
                    'parts' => [['text' => $textPrompt]]
                ]
            ],
        ] + array_intersect_key($options, array_flip(['temperature', 'maxOutputTokens']));

        $client = Http::acceptJson()
            ->timeout(12)
            ->connectTimeout(5);
        if ($bearerToken) {
            $client = $client->withToken($bearerToken);
        } elseif (!empty($this->token)) {
            $client = $client->withHeaders(['x-goog-api-key' => $this->token]);
        }

        $response = $client->post($url, $payload);

        if (!$response->ok()) {
            Log::error('Gemini generateContent failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'url' => $url
            ]);
            throw new Exception('Gemini request failed with status: ' . $response->status());
        }

        $json = $response->json();
        return [
            'raw'  => $json,
            'text' => $this->extractTextFromGemini($json),
        ];
    }

    protected function extractTextFromGemini(array $json): string
    {
        if (isset($json['candidates'][0]['content']['parts'][0]['text'])) {
            return trim($json['candidates'][0]['content']['parts'][0]['text']);
        }
        if (isset($json['candidates'][0]['content']['parts'])) {
            $texts = [];
            foreach ($json['candidates'][0]['content']['parts'] as $p) {
                if (isset($p['text'])) {
                    $texts[] = $p['text'];
                }
            }
            return trim(implode("\n", $texts));
        }

        if (isset($json['output'])) {
            return is_string($json['output'])
                ? trim($json['output'])
                : json_encode($json['output'], JSON_UNESCAPED_UNICODE);
        }

        return json_encode($json, JSON_UNESCAPED_UNICODE);
    }


    /** ================= Intent ================= */

    protected function defaultIntent(): array
    {
        return [
            'intent' => 'unknown',
            'wallet' => null,
            'from'   => null,
            'to'     => null,
            'limit'  => null,
        ];
    }

    protected function extractIntentFromText(string $message): array
    {
        $system = <<<'TXT'
        Bạn là một bộ phân tích câu hỏi về tài chính/chi tiêu. TRẢ VỀ CHÍNH XÁC MỘT JSON duy nhất (không kèm giải thích).
        Các field:
        - intent: one of [check_balance, recent_transactions, total_spending, spending_by_category, unknown]
        - wallet: nullable, tên ví / account nếu user chỉ rõ (string)
        - from: nullable, yyyy-mm-dd
        - to: nullable, yyyy-mm-dd
        - limit: nullable integer
        Nếu không chắc, trả null cho field tương ứng. 
        Ví dụ: {"intent":"check_balance","wallet":"Ví chính","from":null,"to":null,"limit":null}
        TXT;

        $prompt = $system . "\n\nUser query: " . $message . "\nTrả về JSON như hướng dẫn.";
        $resp = $this->generateContent($prompt);

        $raw = $resp['text'] ?? '';
        $json = json_decode($raw, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
            return $json;
        }

        if (preg_match('/\{.*\}/s', $raw, $m)) {
            $json2 = json_decode($m[0], true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($json2)) {
                return $json2;
            }
        }

        return $this->defaultIntent();
    }

    /** ================= Handle Intents ================= */

    protected function handleIntentAndFetchData(int $userId, array $intentData): array
    {
        return match ($intentData['intent'] ?? 'unknown') {
            'check_balance'       => $this->handleCheckBalance($userId, $intentData),
            'recent_transactions' => $this->handleRecentTransactions($userId, $intentData),
            'total_spending'      => $this->handleTotalSpending($userId, $intentData),
            'spending_by_category' => $this->handleSpendingByCategory($userId, $intentData),
            default               => ['intent' => 'unknown'],
        };
    }

    protected function handleCheckBalance(int $userId, array $intentData): array
    {
        $walletName = $intentData['wallet'] ?? null;
        if ($walletName) {
            $wallet = $this->walletService->findByUserAndName($userId, $walletName);
            if (!$wallet) {
                return ['error' => "Không tìm thấy ví '{$walletName}' của bạn."];
            }
            $balance = $this->walletService->getBalance($wallet->id);
            return ['intent' => 'check_balance', 'wallet' => $wallet->name, 'balance' => (float)$balance];
        }

        $total = $this->walletService->getTotalBalanceByUser($userId);
        return ['intent' => 'check_balance', 'total_balance' => (float)$total];
    }

    protected function handleRecentTransactions(int $userId, array $intentData): array
    {
        $from  = $intentData['from'] ?? null;
        $to    = $intentData['to'] ?? null;
        $limit = $intentData['limit'] ?? 10;

        $rows = $this->transactionService->listByRange($userId, $from, $to, $limit);
        $arr = [];
        foreach ($rows as $r) {
            $arr[] = [
                'id'          => $r->id,
                'date'        => (string)$r->transaction_date,
                'amount'      => (float)$r->amount,
                'category'    => $r->category,
                'description' => $r->description,
            ];
        }

        return ['intent' => 'recent_transactions', 'transactions' => $arr];
    }

    protected function handleTotalSpending(int $userId, array $intentData): array
    {
        $from = $intentData['from'] ?? now()->startOfMonth()->toDateString();
        $to   = $intentData['to'] ?? now()->endOfMonth()->toDateString();

        $sum = $this->transactionService->sumByUserAndRange($userId, $from, $to, TransactionConst::EXPENSE);

        return ['intent' => 'total_spending', 'total' => (float)$sum, 'from' => $from, 'to' => $to];
    }

    protected function handleSpendingByCategory(int $userId, array $intentData): array
    {
        $from = $intentData['from'] ?? null;
        $to   = $intentData['to'] ?? null;

        if (!empty($intentData['category'])) {
            $cat = $intentData['category'];
            $sum = $this->transactionService->sumByUserCategoryAndRange($userId, $cat, $from, $to);
            return ['intent' => 'spending_by_category', 'category' => $cat, 'total' => (float)$sum];
        }

        $rows = $this->transactionService->sumByCategory($userId, $from, $to);
        $arr = [];
        foreach ($rows as $r) {
            $arr[] = ['category' => $r->category, 'total' => (float)$r->total];
        }

        return ['intent' => 'spending_by_category', 'categories' => $arr];
    }

    /** ================= Compose reply ================= */

    protected function composeNaturalReply(string $userMessage, array $dataForReply): string
    {
        $system = "Bạn là Nhân viên Chăm sóc Khách hàng của MyExpenseVN – ứng dụng quản lý chi tiêu cá nhân và gia đình.
            Nhiệm vụ của bạn:
            - Trả lời bằng tiếng Việt, ngắn gọn, dễ hiểu, thân thiện và tôn trọng.
            - Luôn giữ thái độ tích cực, lịch sự, kiên nhẫn.
            - Xác định rõ vấn đề khách hàng trước khi trả lời. Nếu thông tin chưa đủ thì đặt câu hỏi để làm rõ.
            - Với yêu cầu phức tạp, hãy chia nhỏ thành các bước và hướng dẫn tuần tự.
            - Luôn đưa ra giải pháp hoặc bước tiếp theo. Nếu có nhiều lựa chọn, hãy so sánh và đề xuất phương án phù hợp.
            - Khi gặp sự cố hoặc khiếu nại: xin lỗi lịch sự, thể hiện sự đồng cảm và cam kết hỗ trợ.
            - Nếu không tìm thấy thông tin chính xác trong dữ liệu nội bộ: hãy trả lời “Xin lỗi, tôi chưa có thông tin chính xác về vấn đề này. Anh/chị vui lòng liên hệ bộ phận hỗ trợ qua email support@myexpense.vn để được trợ giúp chi tiết hơn ạ.”
            - Bảo mật tuyệt đối dữ liệu khách hàng, không tiết lộ thông tin nhạy cảm.
            - Không bịa đặt, không suy đoán, không dùng ngôn ngữ tiêu cực.
            - Trình bày nội dung trả lời bằng HTML cơ bản (<b>, <i>, <ul>, <li>, <br>) để gọn gàng, dễ đọc trong khung chat.";

        $resp = $this->generateContent($system . "\n\nDữ liệu nội bộ: "
            . json_encode($dataForReply, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            . "\n\nCâu hỏi của khách hàng: " . $userMessage);

        return $resp['text'] ?? "Xin lỗi, hiện tại tôi chưa lấy được câu trả lời. Anh/chị vui lòng thử lại sau ạ.";
    }

    /** ================= Main entry ================= */

    public function handleUserQuery(int|string|null $userId, ?int $conversationId, string $message): array
    {
        if (!$userId) {
            throw new Exception("User ID is required");
        }

        if (empty($conversationId)) {
            $conv = $this->aiConversationService->create(['title' => null, 'user_id' => $userId]);
            $conversationId = $conv->id ?? null;
        }

        $this->aiMessageService->create([
            'conversation_id' => $conversationId,
            'sender'          => 'user',
            'message'         => $message,
            'user_id'         => $userId,
        ]);

        $intentData = $this->extractIntentFromText($message);
        $data = $this->handleIntentAndFetchData($userId, $intentData);

        $reply = $data['error'] ?? $this->composeNaturalReply($message, $data);

        $aiMsg = $this->aiMessageService->create([
            'conversation_id' => $conversationId,
            'sender'          => 'ai',
            'message'         => $reply,
            'user_id'         => $userId,
        ]);

        return [
            'reply'          => $reply,
            'conversation_id' => $conversationId,
            'ai_message_id'  => $aiMsg->id ?? null,
        ];
    }
}
