<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Faker\Provider\Lorem;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request) {

        $categories = [
            null => __('Все категории'), 
            1 => __('Первая категория'), 
            2 => __('Вторая категория')
        ];

        
        $validated = $request->validate([
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
            
            'page' => ['nullable', 'integer', 'min:1', 'max:100']
        ]);
        
        # pagination manually
        // $page = $validated['page'] ?? 1;
        // $limit = $validated['limit'] ?? 12;
        // $offset = $limit * ($page - 1);
        // $posts = Post::query()->limit($limit)->offset($offset)->get(['id', 'title', 'content', 'published_at']);
        
        $posts = Post::query()->orderBy('published_at', 'desc')->paginate(12, ['id', 'title', 'published_at']);

        return view('blog.index', compact('posts', 'categories'));
    }

    public function show($post) {
        $post = (object) [
            'id' => 1,
            'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo, a.',
            'content' => 'Lorem ipsum <strong>dolor</strong> sit amet, consectetur adipisicing elit. Tempora laudantium, nemo nihil beatae illo vel?',
        ];
        
        return view('blog.show', compact('post'));
    }
}