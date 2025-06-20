<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'wallet_id',
        'category_id',
        'amount',
        'transaction_type',
        'occurred_at',
        'description',
    ];

    // ============================= Relation =============================
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class)->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }
}
