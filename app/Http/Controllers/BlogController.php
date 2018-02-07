<?php

namespace App\Http\Controllers;

use App\Services\BlogValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\BlogModel;
use App\BlogCategoryModel;
use Intervention\Image;

class BlogController extends Controller
{

    public function __construct()
    {
        $this->blog = new BlogModel();
        $this->blogCategory = new BlogCategoryModel();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('blog.index');
    }

    /**
     * List all blogs.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllBlog()
    {
        $result = $this->blog->index();
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, BlogValidationService $blogValidationService)
    {

        try {

            $validate = $blogValidationService->validateForm($request->all());
            if($validate['status'] == 1){
                return response()->json($validate);
            }

            if(str_contains($request->image, ',')){
                $explodeImg = explode(',', $request->image);
                if(str_contains($explodeImg[0], 'jpg')){
                    $ext = 'jpg';
                } elseif(str_contains($explodeImg[0], 'png')){
                    $ext = 'png';
                } elseif(str_contains($explodeImg[0], 'gif')){
                    $ext = 'gif';
                } elseif(str_contains($explodeImg[0], 'jpeg')) {
                    $ext = 'jpeg';
                } else {
                    $ext = 'txt';
                }
                $decodeImg = base64_decode($explodeImg[1]);
                $fileName = str_random(10).'-blog.'.$ext;
                // File upload
                $destinationPath = base_path('public/uploads/blogs/'); // upload path
                file_put_contents($destinationPath.$fileName, $decodeImg);
                \Image::make($destinationPath.$fileName)->resize(530, 255)
                    ->save(base_path('public/uploads/blogs/' . $fileName));
                $request->request->add(['created_at' => date('Y-m-d H:i:s')]);
                $request->request->add(['updated_at' => date('Y-m-d H:i:s')]);
                $request->request->add(['image' => $fileName]);
                $postId = $this->blog->savePost($request->except(['_token','category_id']));
            } else {
                $postId = $this->blog->savePost($request->except(['_token','category_id','image']));
            }
            $message = ['status' => 0, 'message' => array('Record added successfully')];
            $categories = [];
            foreach($request->category_id as $val){
                array_push($categories, ['blog_id' => ($request->id ?? $postId),'category_id' => $val]);
            }
            $this->blogCategory->saveBlogCategory($categories);

            return response()->json($message);

        } catch(\Exception $e) {
            return response()->json(['status' => 1, 'message' => array($e->getMessage())]);
        }

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $image = BlogModel::where('id', $request->id)->first(['image']);
        if(!empty($image['image']) && file_exists(base_path('public/uploads/blogs/').$image['image'])){
            unlink(base_path('public/uploads/blogs/').$image['image']);
        }
        $delete = BlogModel::find($request->id)->delete();
        return response()->json(['status' => 1]);
    }
}
