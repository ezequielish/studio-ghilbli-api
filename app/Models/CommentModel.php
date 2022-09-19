<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    protected $table = 'comments';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
