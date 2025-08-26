<?php

namespace App\Models;

use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
        'code',
        'currency',
        'status',
        'receipt_image',
        'parent_transaction_id',
        'is_reversal'
    ];
    // ============================= Booted ===============================
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = (string) Str::ulid();
        });
    }
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

    public function parentTransaction()
    {
        return $this->belongsTo(Transaction::class, 'parent_transaction_id','id');
    }

    public function reversal()
    {
        return $this->belongsTo(Transaction::class, 'parent_transaction_id','id');
    }
}
