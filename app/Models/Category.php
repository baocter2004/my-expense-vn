<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'group_id',
        'name',
        'is_active',
        'descriptions'
    ];

    // ============================= Attributes ===========================
    public $attributes = [
        'is_active' => 0
    ];

    // ============================= Relation =============================
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function group()
    {
        return $this->belongsTo(Group::class)->withTrashed();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
