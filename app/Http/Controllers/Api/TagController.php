<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show($slug) {
        $tag = Tag::where('slug', '=', $slug)->with(['posts'])->first();
        if ($tag) {
            return response()->json([
                'success' => true,
                'results' => $tag
            ]);
        }
        return response()->json([
            'success' => false,
            'error' => 'Nessun tag trovato'
        ]);
    }
}
