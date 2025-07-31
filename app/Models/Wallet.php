<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Expr\FuncCall;

class Wallet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'balance',
        'currency',
        'note',
        'is_default'
    ];

    protected $casts = [
        'balance' => 'float',
        'currency' => 'integer',
    ];

    protected $attributes = [
        'is_default' => 0
    ];

    // =========================== Relation ============================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
