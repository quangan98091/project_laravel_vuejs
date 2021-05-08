<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Category;

class CategoryController extends Controller
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
        return Category::with('user')->latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, 
            [
                "thumbnail" => 'required',
                "title" => 'required|unique:categories'
            ],
            [
                'thumbnail.required' => 'Hình ảnh thể loại không được để trống.',
                'title.required' => 'Tên thể loại không được để trống.',
                'title.unique' => 'Tên thể loại đã tồn tại.'
            ]
        );

        $thumbnail = time().'.' . explode('/', explode(':', substr($request->thumbnail, 0, strpos($request->thumbnail, ';')))[1])[1];

        \Image::make($request->thumbnail)->save(public_path('img/category/').$thumbnail);

        return Category::create([
            'user_id' => $request['user_id'],
            'thumbnail' => $thumbnail,
            'title' => $request['title'],
            'slug' => Str::slug($request['title'], '-'),
            'is_published' => $request['is_published']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $category = Category::findOrFail($id);

        $this->validate($request, 
            [
                'title' => 'required|unique:categories,title,' . $category->id
            ],
            [
                'title.required' => 'Tên thể loại không được để trống.',
                'title.unique' => 'Tên thể loại đã tồn tại.'
            ]
        );

        $currentPhoto = $category->thumbnail;

        if($request->thumbnail != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->thumbnail, 0, strpos($request->thumbnail, ';')))[1])[1];

            \Image::make($request->thumbnail)->save(public_path('img/category/').$name);
            $request->merge(['thumbnail' => $name]);

            $image = public_path('img/category/').$currentPhoto;
            if(file_exists($image)){
                @unlink($image);
            }

        }

        $category->slug = Str::slug($request->title, '-');

        $category->update($request->all());
        return ['message' => 'Updated success'];
    }

    public function updateIsPublished(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->is_published = $request->is_published;

        $category->save();
        return ['message' => 'Updated success'];
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $image = public_path('img/category/').$category->thumbnail;
        if(file_exists($image)){
            @unlink($image);
        }

        $category->delete();

        return ['message' => 'Deleted success'];
    }

    public function search(){

        if ($search = \Request::get('q')) {
            $category = Category::where(function($query) use ($search){
                $query->where('title','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $category = Category::latest()->paginate(10);
        }

        return $category;

    }
}
