<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use  Illuminate\Foundation\Auth\User as Authenticable;

class User extends Authenticable
{
    // user details
    public function details(): HasOne
    {
        return $this->hasOne(UserDetail::class);
    }

    // department
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
