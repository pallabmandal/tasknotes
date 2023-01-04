<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskNote extends Model
{
    use HasFactory;

    public function attachment()
    {
        return $this->hasMany(\App\Models\TaskNoteAttachment::class);
    }
}
