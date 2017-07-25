<?php

namespace App\Http\Controllers;

use App\Category;
use App\Events\ThreadBodyWasUpdated;
use App\Http\Requests\CreateThread;
use App\Tag;
use App\Thread;
use App\Filters\ThreadFilters;
use App\ThreadStatus;
use App\User;
use Carbon\Carbon;
use function GuzzleHttp\json_encode;
use Illuminate\Http\Request;

class ThreadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource, if category is given, return matching
     *
     * @param Category $category
     * @param ThreadFilters $filters
     * @return \Illuminate\Http\Response
     * @internal param null $categoryId
     */
    public function index(Category $category, ThreadFilters $filters)
    {
        $threads = $this->getThreads($category, $filters);

        //only tags, that belong to a thread, order by count for each thread
        $tags = Tag::getPopularTags();
        //array for JQCloud plugin
        $cloud = Tag::toCloudArray($tags);

        //date filters
        $dateFrom = request('dateFrom') ?: 'Od...';
        $dateTo = request('dateTo') ?: 'Do...';

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index',
            compact('threads', 'tags', 'cloud', 'dateFrom', 'dateTo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateThread|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateThread $request)
    {
        $thread = $request->persistCreate();

        $thread->subscribe();

        return redirect($thread->path())
            ->with('flash', 'Objava je bila uspešno dodana.');
    }

    /**
     * Display the specified resource.
     *
     * @param $categoryId
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show($categoryId, Thread $thread)
    {
        $neededVotes = $thread->neededVotesToPass();
        $isUpVotedOn = $thread->isUpVotedOn;
        $isDownVotedOn = $thread->isDownVotedOn;

        $governmentReply =  $thread->replies->where('user_id', 7)->first();

        return view('threads.show', compact('thread', 'neededVotes', 'isUpVotedOn', 'isDownVotedOn', 'governmentReply'));
        //dont need replies, because it gets requested on frontend with vue
        //'replies' => $thread->replies()->paginate(10)
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit($categoryId, Thread $thread)
    {
        $this->authorize('editBody', $thread);

        return view('threads.edit', compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update($categoryId, Thread $thread, Request $request)
    {
        $this->authorize('update', $thread);

        //if only thread_status_id is being updated
        if($request['thread_status_id']){
            $thread->changeStatus($request['thread_status_id']);
        } else {
            $this->authorize('editBody', $thread);
            $this->validate($request, [
                'category_id' => 'required|exists:categories,id',
                'title' => 'required',
                'body' => 'required',
                'tags' => 'required'
            ]);

            //adding tags (sync removes the ones taht arent in array)
            $thread->tags()->sync(\App\Tag::createTags(request('tags')));

            $thread->update([
                'category_id' => $request['category_id'],
                'title' => $request['title'],
                'body' => $request['body']]);

            //notify subscribers and all that voted
            event(new ThreadBodyWasUpdated($thread));

            //pobriše vse glasove on update
            $thread->votes->each->delete();

        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($category, Thread $thread)
    {
        //ThreadPolicy, in case of error, returns 403
        $this->authorize('delete', $thread);

        \DB::transaction(function() use ($thread) {
            $thread->replies->each->delete();
            $thread->votes->each->delete();
            $thread->delete();
        });

        if(request()->wantsJson()){
            return response([], 204);
        }

        return redirect('/threads');
    }

    /**
     * @param Category $category
     * @param ThreadFilters $filters
     * @return mixed
     */
    public function getThreads(Category $category, ThreadFilters $filters)
    {

        //search išče LIKE po creator name, tags name, title.
        $query = request('search');
        if($query){
            return static::search($query);
        }

        //calls scopeFilter from model and app/Filters/ThreadFilters
        $threads = Thread::latest()->with('votes')->filter($filters);

        if ($category->exists) {
            $threads->where('category_id', $category->id);
        }

        //use paginate(10) instead get if needed, and uncomment links() in view
        return $threads->paginate(10);
    }

    public static function search($query)
    {
        return Thread::where('title', 'LIKE', '%'. $query . '%' )
            ->orwhereHas('creator', function($user) use($query) {
                $user->where('name','LIKE', '%'. $query . '%' );
            })
            ->orWhereHas('tags', function($tag) use ($query) {
                $tag->where('name','LIKE', '%'. $query . '%' );
            })
            ->latest()->with('votes')->paginate(10);

    }
}
