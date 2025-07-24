<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'subject',
        'message',
        'subscribe',
        'status',
        'ip_address',
        'user_id'
    ];

    protected function casts(): array
    {
        return [
            'status' => 'integer',
        ];
    }

}
