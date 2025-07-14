<?php

namespace App\Services\Client;

use App\Consts\GlobalConst;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Services\BaseCRUDService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CategoryService extends BaseCRUDService
{
    protected function getRepository(): CategoryRepository
    {
        if (empty($this->repository)) {
            $this->repository = app()->make(CategoryRepository::class);
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

        $relates = ['transactions'];
        
        if (!empty($params['keyword'])) {
            $wheres[] = [
                function ($query) use ($params) {
                    $query->where('categories.id', '=', $params['keyword'])
                        ->orWhere('categories.name', 'like', '%' . $params['keyword'] . '%')
                        ->orWhere('categories.descriptions', 'like', '%' . $params['keyword'] . '%');
                }
            ];
        }

        return [
            'wheres' => $wheres,
            'likes'  => $whereLikes,
            'sort'   => $sort . ':' . $order,
            'relates' => $relates,
        ];
    }

    public function getList(int|string $id, array $params, $limit = GlobalConst::DEFAULT_LIMIT)
    {
        if (!empty($params['limit'])) {
            $limit = $params['limit'];
        }

        $params['wheres'][] = ['user_id', '=', $id];

        $query = $this->filter($params);

        return $query->paginate($limit)->appends(request()->query());
    }

    public function create(array $params = []): Category
    {
        try {
            $params['user_id'] = Auth::id();
            $params['is_active'] = isset($params['is_active']) ? $params['is_active'] : 0;

            $category = $this->repository->create($params);

            return $category;
        } catch (\Throwable $th) {
            Log::error('Error in ' . __CLASS__ . '::' . __FUNCTION__ . ' => ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }

    public function updateStatus($id, $status)
    {
        try {
            $category = parent::find($id);
            if ($category) {
                $category->is_active = $status;
                $category->save();
                return $category;
            }
            return false;
        } catch (\Throwable $th) {
            Log::error('Error in ' . __CLASS__ . '::' . __FUNCTION__ . ' => ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $category = $this->repository->with(['transactions'], $id);

            if (! $category) {
                return [
                    'status' => false,
                    'message' => 'Danh mục không tồn tại.',
                ];
            }

            if ($category->user_id !== Auth::id()) {
                return [
                    'status' => false,
                    'message' => 'Bạn không có quyền xoá danh mục này.',
                ];
            }

            if ($category->transactions->isNotEmpty()) {
                return [
                    'status' => false,
                    'message' => 'Không thể xoá vì danh mục đã có giao dịch.',
                ];
            }


            $this->repository->delete($id);

            return [
                'status' => true,
                'message' => 'Xoá danh mục thành công.',
            ];
        } catch (\Throwable $th) {
            Log::error('Error in ' . __CLASS__ . '::' . __FUNCTION__ . ' => ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
            return [
                'status' => false,
                'message' => 'Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau.',
            ];
        }
    }
}
