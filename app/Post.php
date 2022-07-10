<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        'category_id'
    ];

    public function tags(){
        return $this->belongsToMany('App\Tag');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public static function generatePostSlugFromTitle($title) {
        // generaimo slug base
        // finchè slug esiste nel db
        // aggiungiamo numero progressivo, 
        // se non esiste, salvo slug nel model
        $base_slug = Str::slug($title, '-'); // mio-post
        $slug = $base_slug; // mio-post
        $count = 1;
        $post_found = Post::where('slug', '=', $slug)->first();
        while ($post_found) {
            $slug = $base_slug . '-' . $count; // mio-post-1
            $post_found = Post::where('slug', '=', $slug)->first();
            $count++; // 2
        }

        return $slug;
    }
}
