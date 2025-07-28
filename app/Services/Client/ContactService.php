<?php

namespace App\Services\Client;

use App\Models\Contact;
use App\Repositories\ContactRepository;
use App\Services\BaseCRUDService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContactService extends BaseCRUDService
{
    public function getRepository(): ContactRepository
    {
        if (empty($this->repository)) {
            $this->repository = app()->make(ContactRepository::class);
        }
        return $this->repository;
    }

    protected function buildFilterParams(array $params): array
    {
        $wheres     = Arr::get($params, 'wheres', []);
        $whereLikes = Arr::get($params, 'likes', []);
        $sort       = Arr::get($params, 'sort', 'created_at');
        $order      = Arr::get($params, 'order', 'desc');
        $relates    = Arr::get($params, 'relates', []);

        return [
            'wheres' => $wheres,
            'likes'  => $whereLikes,
            'sort'   => $sort . ':' . $order,
            'relates' => $relates,
        ];
    }

    public function submitContact(array $params = []): array
    {
        sleep(1);
        try {
            $params['user_id'] = Auth::id() ?? null;
            $params['subscribe'] = isset($params['subscribe']) ? $params['subscribe'] : 0;
            $params['ip_address'] = request()->ip();

            $filterParams = [
                'wheres' => [
                    ['email', $params['email']],
                    ['last_name', $params['last_name']],
                    ['first_name', $params['first_name']],
                    ['created_at', '>=', now()->subMinutes(15)],
                ],
            ];


            $latest = $this->filter($filterParams)->first();

            if ($latest) {
                return [
                    'success' => false,
                    'message' => 'Bạn đã gửi liên hệ gần đây. Vui lòng thử lại sau 15 phút.',
                ];
            }

            $contact = $this->repository->create($params);

            return [
                'success' => true,
                'message' => 'Gửi liên hệ thành công!',
                'data' => $contact,
            ];
        } catch (\Throwable $th) {
            Log::error('Error in ' . __CLASS__ . '::' . __FUNCTION__ . ' => ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.',
            ];
        }
    }
}
