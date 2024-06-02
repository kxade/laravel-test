<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    public function index() {
        $posts = Post::query();

        return view('user.posts.index', compact('posts'));
    }

    public function create() {
        return view('user.posts.create');
    }

    public function store(StorePostRequest $request) {
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string', 'max:1000'],
            'published_at' => ['nullable', 'string', 'date'],
            'published' => ['nullable', 'boolean'],
        ]);
        
        $post = Post::query()->create([
            'user_id' => User::query()->value('id'),
            'category_id' => 1,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => new Carbon($validated['published_at'] ?? null),
            'published' => $validated['published'] ?? false,
        ]);
        // $validated = $request->validated(); use with custom request class

        
        // $validator = validator($request->all(), [
        //     'title' => ['required', 'string', 'max:100'],
        //     'content' => ['required', 'string', 'max:1000'],
        // ]);

        // $validated = $validator->validate();

        // if (true) {
        //     throw ValidationException::withMessages([
        //         'account' => __('Недостаточно средств'),
        //     ]);
        // }

        dd($post);


        return redirect()->route('user.posts.show', 1);
    }

    public function show($post) {
        $post = (object) [
            'id' => 1,
            'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo, a.',
            'content' => 'Lorem ipsum <strong>dolor</strong> sit amet, consectetur adipisicing elit. Tempora laudantium, nemo nihil beatae illo vel?',
        ];

        return view('user.posts.show', compact('post'));
    }

    public function edit($post) {
        $post = (object) [
            'id' => 1,
            'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo, a.',
            'content' => 'Lorem ipsum <strong>dolor</strong> sit amet, consectetur adipisicing elit. Tempora laudantium, nemo nihil beatae illo vel?',
        ];
        

        return view('user.posts.edit', compact('post'));
    }

    public function update(Request $request, $post) {

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string', 'max:1000'],
            'published_at' => ['nullable', 'string', 'date'],
            'published' => ['nullable', 'boolean'],
        ]);

        dd($validated);

        // return redirect()->route('user.posts.show', $post);
        return redirect()->back();
    }

    public function destroy($post) {
        return redirect()->route('user.posts');
    }

    public function like() {
        return 'Лайк + 1';
    }
}
