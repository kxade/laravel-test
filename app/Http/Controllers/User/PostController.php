<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    public function index() {
        $post = (object) [
            'id' => 1,
            'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo, a.',
            'content' => 'Lorem ipsum <strong>dolor</strong> sit amet, consectetur adipisicing elit. Tempora laudantium, nemo nihil beatae illo vel?',
        ];

        $posts = array_fill(0, 10, $post);
        return view('user.posts.index', compact('posts'));
    }

    public function create() {
        return view('user.posts.create');
    }

    public function store(StorePostRequest $request) {
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string', 'max:1000'],
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

        dd($validated);


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
