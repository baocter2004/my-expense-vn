<?php

namespace App\Services\Client;

use App\Consts\GlobalConst;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\BaseCRUDService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

    public function show(int|string $id, array $params = [])
    {
        $filterParams = array_merge($params, [
            'wheres'  => ['id' => $id],
            'relates' => ['categories', 'wallets'],
        ]);

        $user = $this->filter($filterParams)->first();
        if (! $user) {
            return null;
        }

        $categories = $user->categories()
            ->paginate(
                Arr::get($params, 'categories_limit', 10),
                ['*'],
                'categories_page',
                Arr::get($params, 'categories_page', 1)
            );

        $wallets = $user->wallets()
            ->paginate(
                Arr::get($params, 'wallets_limit', 10),
                ['*'],
                'wallets_page',
                Arr::get($params, 'wallets_page', 1)
            );

        $transactions = $user->transactions()
            ->orderBy('occurred_at', 'desc')
            ->paginate(
                Arr::get($params, 'transactions_limit', 10),
                ['*'],
                'transactions_page',
                Arr::get($params, 'transactions_page', 1)
            );

        return [
            'id'           => $id,
            'user'         => $user,
            'categories'   => $categories,
            'wallets'      => $wallets,
            'transactions' => $transactions,
        ];
    }

    public function updateAvatar(int $userId, \Illuminate\Http\UploadedFile $file): ?string
    {
        return DB::transaction(function () use ($userId, $file) {
            $user = $this->find($userId);

            $folder = 'users/avatars';

            $path = $file->store($folder, 'public');

            if ($user->avatar && $user->avatar !== $path) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->update([
                'avatar' => $path,
            ]);

            return $path;
        });
    }
    public function handleChangePassword(int $userId, array $data): void
    {
        $user = $this->find($userId);

        $isGoogleFirstChange = $user->google_id !== null && !$user->is_change_password;

        if ($isGoogleFirstChange) {
            Validator::make($data, [
                'new_password' => 'required|min:8|confirmed',
            ])->validate();
        } else {
            Validator::make($data, [
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ])->validate();

            if (!Hash::check($data['current_password'], $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => ['Mật khẩu hiện tại không đúng.'],
                ]);
            }
        }

        $this->update($userId, [
            'password' => $data['new_password'],
            'is_change_password' => 1,
        ]);
    }
}
