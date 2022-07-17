<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('index');
        // $posts = Post::all();
        $posts = Post::paginate(9);
        // dd($posts);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd('create');
        $categories = Category::all();
        $tags= Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Visualizzazione dati
        $request->validate($this->getValidationRules());

        $data = $request->all();
        // dd($data);

        // gestione di salvataggio dell'immagine
        if (isset($data['image'])) {
            $image_path = Storage::put('post_covers', $data['image']);
            $data['cover'] = $image_path;
        }

        $post = new Post();
        $post->fill($data);
        $post->slug = $this->generatePostSlugFromTitle($post->title);
        $post->save();

        //colegamento con i vari tag
        if(isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        //

        // Mail::to('superadmin@boopress.it')->send(new NewNotificationToAdmin());
        return redirect()->route('admin.posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd('show');
        $post = Post::findOrFail($id);
        // dd($post);
        $category = $post->category; 
        return view('admin.posts.show', compact('post', 'category'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd('edit');
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
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
        $request->validate($this->getValidationRules());

        $data = $request->all();
        // dd($data);
        $post = Post::findOrFail($id);

           // Se nel data c'è immagine
           if (isset($data['image'])) {
            //  Cancellare l'immagine precedente se c'è
            if ($post->cover) {
                Storage::delete($post->cover);
            }
            //  Salvare l'immagine nuova
            $image_path = Storage::put('post_covers', $data['image']);
            //  Salvare il path dell'immagine nel data
            $data['cover'] = $image_path;
        }

        // Metodo fill + save
        // $post->fill($data);
        // $post->slug = Post::generatePostSlugFromTitle($post->title);
        // $post->save();

        // Metodo update
        $data['slug'] = Post::generatePostSlugFromTitle($data['title']);
        $post->update($data);

        if(isset($data['tags'])){
            $post->tags()->sync($data['tags']);
        } else {
            $post->tag()->sync([]);
        }

        return redirect()->route('admin.posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            // dd('destroy');
            $post = Post::findOrFail($id);
            $post->tags()->sync([]);

            // Se c'è l'immagine cover, allora la cancelliamo
            if($post->cover) {
                Storage::delete($post->cover);
            }

            $post->delete();
            // dd($comic);
            return redirect()->route('admin.posts.index');
    }

    private function generatePostSlugFromTitle($title) {
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

    private function getValidationRules() {
        return [
            'title' => 'required|max:255',
            'content' => 'required|max:30000',
            'category_id' => 'nullable|exists:categories,id',
            'tags'=> 'nullable|exists:tags,id',
            'image' => 'image|max:512'
        ];
    }
}
