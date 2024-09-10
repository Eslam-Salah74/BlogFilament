<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Controllers\Api\ApiResponceTrait;

class PostController extends Controller
{
    use ApiResponceTrait; 

    public function index(){
        // $posts = Post::get();
        // $posts = PostResource::collection(Post::get());لو عاوز ارع جزء من البيانات
        // return $this->apiResponse($posts,'تم جلب البيانات بناح',200);

        $posts = Post::with(['category', 'user'])->get();
        $posts = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                // 'category_id' => $post->category_id,
                'category_name' => $post->category->name, // اسم القسم
                // 'user_id' => $post->user_id,
                'user_name' => $post->user->name, // اسم المستخدم
                'title' => $post->title,
                'sub_title' => $post->sub_title,
                'content' => $post->content,
                'sub_content' => $post->sub_content,
                'img' => $post->img,
                'is_published' => $post->is_published,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ];
        });
        return $this->apiResponse($posts,'تم جلب البيانات بناح',200);
    }

    public function show($id){
        $post = Post::find($id);
        // $post = new PostResource(Post::find($id));لو عاوز ارجع جزء من البيانات
        if($post){
            return $this->apiResponse($post,'تم جلب البيانات بناح',200);
        }
            return $this->apiResponse(null,'هذه المنشور غير موجود',401);
        
    }
}
