<?php

namespace App\Http\Controllers\Api;

use App\Models\LastNews;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LastNewsController extends Controller
{
    use ApiResponceTrait; 

    public function index(){
        $lastnews = LastNews::with(['category'])->get();
        $lastnews = $lastnews->map(function ($lastnew) {
            return [
                'id' => $lastnew->id,
                'post_id' => $lastnew->post->id,
                'category_id' => $lastnew->category->id,
                'category_name' => $lastnew->category->name, // اسم القسم
                'post_title' => $lastnew->title,
                'created_at' => $lastnew->created_at,
                'updated_at' => $lastnew->updated_at,
            ];
        });
        return $this->apiResponse($lastnews,'تم جلب البيانات بناح',200);
    }
}
