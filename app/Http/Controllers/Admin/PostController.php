<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|max:255',
                'content' => 'required|min:8',
                'category_id' => 'required|exists:categories,id',
                'tags[]' => 'exists:tags,id'
            ],
            [
                'title.required' => 'you forgot the title.',
                'content.min' => "you're almost there!",
                'content.required' => 'you also forgot the content.',
                'category_id.required' => "Try again, this category doesn't exist.",
                'tags[]' => 'tag non esiste'
            ]
        );
        $postData = $request->all();
        $newPost = new Post();
        $newPost->fill($postData);
        $slug = Str::slug($newPost->title);
        $alternativeSlug = $slug;
        $postFound = Post::where('slug', $alternativeSlug)->first();
        $counter = 1;
        while ($postFound) {
            $alternativeSlug = $slug . '_' . $counter;
            $counter++;
            $postFound = Post::where('slug', $alternativeSlug)->first();
        }
        $newPost->slug = $alternativeSlug;

        $newPost->save();

        //aggiungo tags

        if (array_key_exists('tags', $postData)) {

            // dd($postData['tags']);
            $newPost->tags()->sync($postData['tags']);
        }


        $newPost->save();
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $category = Category::find($post->category_id);
        return view('admin.posts.show', compact('post', 'category'));
    }

    /**
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::all();

        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate(
            [
                'title' => 'required|max:255',
                'content' => 'required|min:8',
                'category_id' => 'required|exists:categories,id'
            ],

            [
                'title.required' => 'you forgot the title.',
                'content.min' => "you're almost there!",
                'content.required' => 'you also forgot the content.',
                'category_id.exists' => "Try again, this category doesn't exist."
            ]
        );
        $postData = $request->all();
        $post->fill($postData);
        $slug = Str::slug($post->title);
        $alternativeSlug = $slug;
        $postFound = Post::where('slug', $alternativeSlug)->first();
        $counter = 1;
        while ($postFound) {
            $alternativeSlug = $slug . '_' . $counter;
            $counter++;
            $postFound = Post::where('slug', $alternativeSlug)->first();
        }
        $post->slug = $alternativeSlug;

        if (array_key_exists('tags', $postData)) {

            // dd($postData['tags']);
            $post->tags()->sync($postData['tags']);
        }
        $post->update();
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        if ($post) {
            $post->tags()->sync([]);
            $post->delete();
        }

        return redirect()->route('admin.posts.index');
    }
}
