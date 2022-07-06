<?php
 
use App\Post;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


class PostTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i=0; $i< 10; $i++){
            $post =new Post();
            $post->title = $faker->sentence();
            $post->content = $faker->paragraph(rand(10, 30), false);
            $post->slug = Str::slug($post->title, '-');
            $post->save();
        }
      
    }
}
