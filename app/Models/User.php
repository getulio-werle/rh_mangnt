<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
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
