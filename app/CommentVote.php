<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentVote extends Model
{
    protected $table = "comment_user";
    protected $fillable = ['reply_id', 'user_id', 'vote_type'];
}
