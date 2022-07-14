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

    public function show($slug) {
        $post = Post::where('slug', '=', $slug)->with(['category', 'tags'])->first();
        if ($post) {
            return response()->json([
                'success' => true,
                'results' => $post
            ]);
        }
        return response()->json([
            'success' => false,
            'error' => 'Nessun post trovato'
        ]);
    }
}
