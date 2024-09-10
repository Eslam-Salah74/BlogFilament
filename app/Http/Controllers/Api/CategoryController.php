<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    use ApiResponceTrait; 

    public function index(){
        $categories = Category::get();
        return $this->apiResponse($categories,'تم جلب البيانات بناح',200);
    }
}
