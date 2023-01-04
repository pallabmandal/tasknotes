<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskNoteAttachment extends Model
{
    use HasFactory;

    public function getFileAttribute($value)
    {
        return env('APP_URL').'/storage/'.$value;
    }
}
