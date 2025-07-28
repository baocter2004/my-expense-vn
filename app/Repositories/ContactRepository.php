<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository extends BaseRepository
{
    function modelName(): string
    {
        return Contact::class;
    }
}
