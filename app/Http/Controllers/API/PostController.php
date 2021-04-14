<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Str;
use App\CategoryPost;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::with(['user','categories'])->latest()->paginate(10);
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
            "thumbnail" => 'required',
            "title" => 'required|unique:posts',
            "details" => "required",
            "categories" => "required"
        ],
            [
                'thumbnail.required' => 'Hình ảnh tiêu đề không được để trống.',
                'title.required' => 'Tiêu đề bài viết không được để trống.',
                'title.unique' => 'Tiêu đề này đã tồn tại.',
                'details.required' => 'Nội dung bài viết không được để trống',
                'categories.required' => 'Hãy chọn ít nhất một thể loại cho bài viết.',
            ]
        );

        $thumbnail = time().'.' . explode('/', explode(':', substr($request->thumbnail, 0, strpos($request->thumbnail, ';')))[1])[1];
      
        $post = new  Post();
        $post->user_id = $request->user_id;
        $post->thumbnail = $thumbnail;
        $post->title = $request->title;
        $post->slug = Str::slug($request->title, '-');
        $post->sub_title = $request->sub_title;
        $post->details = $request->details;
        $post->is_published = $request->is_published;
        $post->view_post = 0;
        $post->view_like = 0;
        $post->view_share = 0;
        $save = $post->save();
        
        if($save) {
            \Image::make($request->thumbnail)->save(public_path('img/post/').$thumbnail);
        }
        $post_type = array();
        foreach($request->categories as $value) {
            foreach($value as $k => $v) {
                if($k == 'id')
                    $post_type[] = $v;
            }
            
        }
        $post->categories()->sync($post_type, false);

        return ['message' => 'Create success'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request, 
            [
                'title' => 'required|unique:posts,title,' . $post->id
            ],
            [
                'title.required' => 'Tiêu đề bài viết không được để trống.',
                'title.unique' => 'Tiêu đề này đã tồn tại.'
            ]
        );
        $currentPhoto = $post->thumbnail;

        if($request->thumbnail != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->thumbnail, 0, strpos($request->thumbnail, ';')))[1])[1];

            \Image::make($request->thumbnail)->save(public_path('img/post/').$name);
            $request->merge(['thumbnail' => $name]);

            $image = public_path('img/post/').$currentPhoto;
            if(file_exists($image)){
                @unlink($image);
            }

        }

        $post->user_id = $request->user_id;
        $post->thumbnail = $request->thumbnail;
        $post->title = $request->title;
        $post->slug = Str::slug($request->title, '-');
        $post->sub_title = $request->sub_title;
        $post->details = $request->details;
        $post->is_published = $request->is_published;
        $save = $post->save();

        $post_type = array();
        foreach($request->categories as $value) {
            foreach($value as $k => $v) {
                if($k == 'id')
                    $post_type[] = $v;
            }
            
        }
        $post->categories()->sync($post_type);

        return ['message' => 'Updated success'];
    }

    public function updateIsPublished(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->is_published = $request->is_published;

        $post->save();
        return ['message' => 'Updated success'];
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $image = public_path('img/post/').$post->thumbnail;
        if(file_exists($image)){
            @unlink($image);
        }

        $post->delete();

        return ['message' => 'Deleted success'];
    }

    public function search(){

        if ($search = \Request::get('q')) {
            $post = Post::where(function($query) use ($search){
                $query->where('title','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $post = Post::latest()->paginate(10);
        }

        return $post;

    }

    public function postUser($user_id)
    {
        return Post::with(['user','categories'])->where('user_id', $user_id)->latest()->get();
    }
}
