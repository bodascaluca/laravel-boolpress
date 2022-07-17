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

        foreach ($posts as $post) {
            // Se c'è il cover, trasformo il path del cover in url completo
            if($post->cover) {
                $post->cover = url('storage/' . $post->cover);
            } 
        }

        return response()->json([
            'success' => true,
            'results'=>$posts
        ]);
    } 

    public function show($slug) {
        $post = Post::where('slug', '=', $slug)->with(['category', 'tags'])->first();
        if ($post) {
            if($post->cover) {
                $post->cover = url('storage/' . $post->cover);
            }
              
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
