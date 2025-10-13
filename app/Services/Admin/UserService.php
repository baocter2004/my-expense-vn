<?php

namespace App\Services\Admin;

use App\Consts\GlobalConst;
use App\Consts\UserConst;
use App\Repositories\UserRepository;
use App\Services\BaseCRUDService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserService extends BaseCRUDService
{
    public function getRepository(): UserRepository
    {
        if (empty($this->repository)) {
            $this->repository = app()->make(UserRepository::class);
        }
        return $this->repository;
    }

    protected function buildFilterParams(array $params): array
    {
        $whereEquals = Arr::get($params, 'where_equals', []);
        $whereLikes  = Arr::get($params, 'where_likes', []);
        $wheres      = Arr::get($params, 'wheres', []);
        $sort        = Arr::get($params, 'sort', 'created_at');
        $order       = Arr::get($params, 'order', 'desc');
        $relates     = Arr::get($params, 'relates', [
            'admin',
            'transactions'
        ]);

        if (!empty($params['from_date'])) {
            $whereEquals[] = ['users.created_at', '>=', $params['from_date']];
        }

        if (!empty($params['to_date'])) {
            $whereEquals[] = ['users.created_at', '<=', $params['to_date']];
        }

        if (!empty($params['first_name'])) {
            $whereLikes['users.first_name'] = $params['first_name'];
        }

        if (!empty($params['last_name'])) {
            $whereLikes['users.last_name'] = $params['last_name'];
        }

        if (!empty($params['email'])) {
            $whereLikes['users.email'] = $params['email'];
        }

        if (!empty($params['is_active'])) {
            $whereEquals['users.is_active'] = $params['is_active'];
        }

        if (!empty($params['gender'])) {
            $whereEquals['users.gender'] = $params['gender'];
        }

        return [
            'wheres'        => $wheres,
            'where_equals' => $whereEquals,
            'where_likes'  => $whereLikes,
            'sort'         => $sort . ':' . $order,
            'relates'      => $relates,
        ];
    }

    public function store(array $params = [])
    {
        try {
            DB::beginTransaction();
            $params['status'] = $params['status'] ?? GlobalConst::ACTIVE;
            if (empty($params['admin_id'])) {
                $params['admin_id'] = Auth::guard('admin')->id();
            }

            if (!empty($params['avatar'])) {
                if ($params['avatar'] instanceof \Illuminate\Http\UploadedFile) {
                    $path = $params['avatar']->store('users/avatars', 'public');
                } else {
                    $filename = uniqid() . '.jpg';
                    $path = "users/avatars/{$filename}";
                    Storage::disk('public')->put($path, $params['avatar']);
                }
                $params['avatar'] = $path;
            }
            $params['email_verified_at'] = Date::now();

            $user = $this->create($params);
            DB::commit();
            return [
                'status' => true,
                'data' => $user,
                'message' => 'Thêm mới người dùng thành công ! Họ Và Tên : ' . $user->fullname
            ];
        } catch (\Throwable $th) {
            Log::error('Error in ' . __CLASS__ . '::' . __FUNCTION__ . ' => ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            DB::rollBack();
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra , vui lòng thử lại !'
            ];
        }
    }

    public function updateUser($userId, array $params = [])
    {
        try {
            DB::beginTransaction();

            $params['status'] = $params['status'] ?? GlobalConst::ACTIVE;
            $params['admin_id'] = $params['admin_id'] ?? Auth::guard('admin')->id();

            if (empty($params['password'])) {
                unset($params['password']);
            } else {
                $params['password'] = bcrypt($params['password']);
            }

            $user = $this->find($userId);

            $avatar = $params['avatar'] ?? null;
            if (isset($params['avatar'])) {
                unset($params['avatar']);
            }

            $newPath = null;
            if ($avatar) {
                if ($avatar instanceof \Illuminate\Http\UploadedFile) {
                    $newPath = $avatar->store("users/avatars", 'public');
                } else {
                    $filename = uniqid() . '.jpg';
                    $newPath = "users/avatars/{$filename}";
                    Storage::disk('public')->put($newPath, $avatar);
                }

                $params['avatar'] = $newPath;
            }

            $user = $this->update($userId, $params);

            if (!empty($newPath) && !empty($user->getRawOriginal('avatar'))) {
                $oldAvatar = $user->getRawOriginal('avatar');
                if ($oldAvatar && $oldAvatar !== $newPath && Storage::disk('public')->exists($oldAvatar)) {
                    Storage::disk('public')->delete($oldAvatar);
                }
            }

            DB::commit();

            return [
                'status' => true,
                'data' => $user,
                'message' => 'Chỉnh sửa người dùng ' . $user->fullname . ' thành công!'
            ];
        } catch (\Throwable $th) {
            Log::error('Error in ' . __CLASS__ . '::' . __FUNCTION__ . ' => ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
            
            if (isset($newPath) && Storage::disk('public')->exists($newPath)) {
                Storage::disk('public')->delete($newPath);
            }

            DB::rollBack();
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }

    public function totalUser(): int
    {
        return $this->repository->count();
    }

    public function getNewUsersWithChange(string $type = 'day'): array
    {
        switch ($type) {
            case 'day':
                $currentStart = now()->startOfDay();
                $currentEnd   = now()->endOfDay();
                $prevStart    = now()->subDay()->startOfDay();
                $prevEnd      = now()->subDay()->endOfDay();
                break;

            case 'month':
                $currentStart = now()->startOfMonth();
                $currentEnd   = now()->endOfMonth();
                $prevStart    = now()->subMonth()->startOfMonth();
                $prevEnd      = now()->subMonth()->endOfMonth();
                break;

            case 'year':
                $currentStart = now()->startOfYear();
                $currentEnd   = now()->endOfYear();
                $prevStart    = now()->subYear()->startOfYear();
                $prevEnd      = now()->subYear()->endOfYear();
                break;

            default:
                return [];
        }

        $current = $this->repository->count([
            'wheres' => [
                ['created_at', '>=', $currentStart],
                ['created_at', '<=', $currentEnd],
            ]
        ]);

        $previous = $this->repository->count([
            'wheres' => [
                ['created_at', '>=', $prevStart],
                ['created_at', '<=', $prevEnd],
            ]
        ]);

        $percent = $previous > 0
            ? (($current - $previous) / $previous) * 100
            : ($current > 0 ? 100 : 0);

        return [
            'value'  => $current,
            'change' => round($percent, 1),
        ];
    }
}
