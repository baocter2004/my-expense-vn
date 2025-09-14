<?php 

namespace App\Services\Client;

use App\Repositories\AiMessageRepository;
use App\Services\BaseCRUDService;
use Illuminate\Support\Arr;

class AiMessageService extends BaseCRUDService
{
    protected function getRepository(): AiMessageRepository
    {
        if(empty($this->repository))
        {
            $this->repository = app()->make(AiMessageRepository::class);
        }
        return $this->repository;
    }
    protected function buildFilterParams(array $params): array
    {
        $wheres = Arr::get($params,'wheres',[]);
        $whereLikes = Arr::get($params,'likes',[]);
        $sort       = Arr::get($params, 'sort', 'created_at');
        $order      = Arr::get($params, 'order', 'desc');
        $relates    = Arr::get($params, 'relates', []);

        return [
            'wheres' => $wheres,
            'likes' => $whereLikes,
            'sort' => $sort . ":" . $order,
            'relates' => $relates
        ];
    }
}