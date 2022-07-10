<?php

use App\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'vagetariano',
            'carne',
            'piatto veloce',
            'pesce',
            'senza glutine',
            'fit',
            'slow food',
            'italiano'
        ];

        foreach($tags as $tag) {
            $new_tag = new Tag();
            $new_tag->nome = $tag;
            $new_tag->slug = Str::slug($tag);
            $new_tag->save();
        } 
    }
}
