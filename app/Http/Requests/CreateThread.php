<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateThread extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'title' => 'required',
                'body' => 'required',
                'category_id' => 'required|exists:categories,id',
                'tags' => 'string|required'
        ];
    }

    public function persistCreate()
    {
        $thread = \App\Thread::create([
            'user_id' => auth()->id(),
            'category_id' => request('category_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);


        $listOfTags = \App\Tag::createTags(request('tags'));

        $thread->tags()->attach($listOfTags);

        return $thread;
    }

    public function persistUpdate()
    {

    }
}
