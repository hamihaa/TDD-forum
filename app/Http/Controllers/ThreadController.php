<?php

namespace App\Http\Controllers;

use App\Category;
use App\Thread;
use App\Filters\ThreadFilters;
use App\User;
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

        if (request()->wantsJson()) {
            return $threads;
        }
        return view('threads.index', compact('threads'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);

        $thread = Thread::create([
           'user_id' => auth()->id(),
            'category_id' => request('category_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);

        return redirect($thread->path());
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
        return view('threads.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(10) ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }

    /**
     * @param Category $category
     * @param ThreadFilters $filters
     * @return mixed
     */
    public function getThreads(Category $category, ThreadFilters $filters)
    {
        $threads = Thread::latest();
        if ($category->exists) {
            $threads->where('category_id', $category->id);
        }

        //calls scopeFilter from model and app/Filters/ThreadFilters
        $threads = $threads->filter($filters)->get();
        return $threads;
    }
}
