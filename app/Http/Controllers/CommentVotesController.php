<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CommentVote;
use App\Reply;

class CommentVotesController extends Controller
{
    public function storeVote(Reply $reply, $type)
    {
        try {
            $reply->vote($type);
            return response()->json('success voting');
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }

    public function updateVote(Reply $reply, $type)
    {
        try {
            $reply->changeVote($type);
            return response()->json('success changing vote');
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }

    public function destroy(Reply $reply)
    {
        try {
            $reply->unvote();
            return response()->json('success');
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }
}
