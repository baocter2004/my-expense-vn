<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends BaseRepository
{
    function modelName(): string
    {
        return Category::class;
    }
    public function countOnlyTrashedByUser($userId): int
    {
        return $this->model
            ->onlyTrashed()
            ->where('user_id', $userId)
            ->count();
    }
}
