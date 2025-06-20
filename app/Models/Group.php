<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'type',
    ];

    // ============================= Relation =============================
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
