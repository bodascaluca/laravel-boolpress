<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts = Post::with(['category'])->paginate(6);
        // dd(response());
        return response()->json([
            'success' => true,
            'results'=>$posts
        ]);
    } 
}
