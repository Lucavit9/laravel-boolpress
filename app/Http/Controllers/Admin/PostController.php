<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
                'tags[]' => 'exists:tags,id',
                'image' => 'required|mimes:png,jpg|max:2048'
            ],
            [
                'title.required' => 'LoL, you forgot the title.',
                'content.min' => "C'mon man, you're almost there!",
                'content.required' => 'LoL, you also forgot the content.',
                'category_id.required' => "Try again, this category doesn't exist.",
                'tags[]' => "This tag doesn't exist",
                'image' => 'This must be an image'
            ]
        );
        $postData = $request->all();
        //Image
        if (array_key_exists('image', $postData)) {
            $img_path = Storage::put('uploads', $postData['image']);
            $postData['cover'] = $img_path;
        }

        $newPost = new Post();
        // $newPost->cover = $img_path;
        $newPost->fill($postData);

        //Slug
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
        //Sync
        if (array_key_exists('tags', $postData)) {
            $newPost->tag()->sync($postData['tags']);
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
        $tag = $post->tag;
        return view('admin.posts.show', compact('post', 'category', 'tag'));
    }

    /**
     * Show the form for editing the specified resource.
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
                'category_id' => 'required|exists:categories,id',
                'tags[]' => 'exists:tags,id'
            ],
            [
                'title.required' => 'LoL, you forgot the title.',
                'content.min' => "C'mon man, you're almost there!",
                'content.required' => 'LoL, you also forgot the content.',
                'category_id.exists' => "Try again, this category doesn't exist."
            ]
        );
        $postData = $request->all();
        //Image
        if (array_key_exists('image', $postData)) {
            if ($post->cover) {
                Storage::delete($post->cover);
            }
            //Una volta che è stata cancellata l'immagine vecchia, carica quella nuova
            $img_path = Storage::put('uploads', $postData['image']);
            $postData['cover'] = $img_path;
        }

        $post->fill($postData);

        //Slug
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
        //Sync
        if (array_key_exists('tags', $postData)) {
            $post->tag()->sync($postData['tags']);
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
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->tag()->sync([]);
        Storage::delete($post->cover);
        $post->delete();

        return redirect()->route('admin.posts.index', compact('post'));
    }
}
