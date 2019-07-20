<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Post;
use App\Category;
use App\Tag;
use App\User;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $author1 = User::create([
            'name' => 'John Doe',
            'email' => 'jdoe@example.com',
            'password' => Hash::make('password')
        ]);

        $author2 = User::create([
            'name' => 'Michael Thorn',
            'email' => 'mthorn@example.com',
            'password' => Hash::make('password')
        ]);

        $category1 = Category::create([
            'name' => 'News'
        ]);

        $category2 = Category::create([
            'name' => 'Marketing'
        ]);

        $category3 = Category::create([
            'name' => 'Product'
        ]);

        $category4 = Category::create([
            'name' => 'Design'
        ]);

        // $author1->posts()->create() means that you don't have to pass in the user_id, it will be done automatically.
        // NOTE: This only works if the User model has a hasMany relationship with the Post model
        $post1 = $author1->posts()->create([
            'title' => "We relocated our office to a new designed garage",
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
            'content' => "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.",
            'category_id' => $category1->id,
            'image' => 'posts/1.jpg',
            //'user_id' => $author1->id
        ]);

        $post2 = $author2->posts()->create([
            'title' => "Top 5 brilliant content marketing strategies",
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
            'content' => "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.",
            'category_id' => $category2->id,
            'image' => 'posts/2.jpg'
        ]);

        $post3 = $author1->posts()->create([
            'title' => "New published books to read by a product designer",
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
            'content' => "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.",
            'category_id' => $category3->id,
            'image' => 'posts/3.jpg'
        ]);

        $post4 = $author2->posts()->create([
            'title' => "Best practices for minimalist design with examples",
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
            'content' => "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.",
            'category_id' => $category4->id,
            'image' => 'posts/4.jpg'
        ]);

        $tag1 = Tag::create([
            'name' => 'Jobs'
        ]);

        $tag2 = Tag::create([
            'name' => 'Customers'
        ]);

        $tag3 = Tag::create([
            'name' => 'Skills'
        ]);

        $post1->tags()->attach([$tag1->id, $tag2->id]);
        $post2->tags()->attach([$tag2->id, $tag3->id]);
        $post3->tags()->attach([$tag1->id, $tag2->id, $tag3->id]);
        $post4->tags()->attach([$tag1->id, $tag3->id]);
    }
}
