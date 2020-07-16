<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'body', 'user_id'];
    // protected $guarded = ['title'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
