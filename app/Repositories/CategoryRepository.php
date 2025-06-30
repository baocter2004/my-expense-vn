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
}