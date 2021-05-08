<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\User;
use App\Post;
use App\CategoryPost;
use App\LikePost;

class FontendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::with(['user','categories'])->where('is_published', 1)->latest()->paginate(9);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Post::with(['user','categories','likePost'])->where('id', $id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function category()
    {
        return Category::with('user')->where('is_published', 1)->get();
    }

    public function categoryRandom()
    {
        return Category::with('user')->where('is_published', 1)->orderByRaw("RAND()")->limit(5)->get();
    }

    public function categoryAll()
    {
        return Category::with('user')->get();
    }

    public function categoryPost(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->first();
        $posts = $category->posts()->with(['user', 'categories'])->where('is_published', '1')->paginate(10);
        return $posts;
      
    }

    public function mostLikedPost() {
        return Post::with('user')->orderBy('view_like', 'DESC')->limit(5)->get();
    }

    public function mostViewedPost() {
        return Post::with('user')->orderBy('view_post', 'DESC')->limit(5)->get();
    }

    public function mostSharePost() {
        return Post::with('user')->orderBy('view_share', 'DESC')->limit(5)->get();
    }

    public function relatedArticles($id) {
        return Post::with('user')->where('id', '!=', $id)->orderByRaw("RAND()")->limit(8)->get();;
    }

    public function addLike($user_id, $post_id)
    {
        $post = Post::findOrFail($post_id);
        $post->view_like = $post->view_like + 1;
        $post->save();
        
        return LikePost::create([
            'post_id' => $post_id,
            'user_id' => $user_id
        ]);
    }

    public function deleteLike($user_id, $post_id)
    {
        $post = Post::findOrFail($post_id);
        $post->view_like = $post->view_like - 1;
        $post->save();

        $like = LikePost::where('post_id', $post_id)->where('user_id',$user_id)->first();
        $like->delete();

        return ['message' => 'Deleted'];
    }
}
