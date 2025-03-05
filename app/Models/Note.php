<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sprout\Database\Eloquent\Concerns\BelongsToTenant;

class Note extends Model
{
    protected $fillable = ['contact_id', 'user_id', 'content'];

    public function contact() :BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

