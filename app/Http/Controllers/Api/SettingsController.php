<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponceTrait;

class SettingsController extends Controller
{
    use ApiResponceTrait; 
    public function index(){
        $settings = Setting::get();
        return $this->apiResponse($settings,'تم جلب البيانات بناح',200);
    }
}
