<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class PostController extends Controller
{
    public function index() {
        return 'Страница списка с постами';
    }

    public function create() {
        return 'Страница создания поста';
    }

    public function store() {
        return 'Сохранить новый пост';
    }

    public function show($post) {
        return "Страница с постом $post для админа";
    }

    public function edit($post) {
        return "Страница редактирования поста $post";
    }

    public function update() {
        return 'Обновление поста';
    }

    public function destroy() {
        return 'Удаление поста';
    }

    public function like() {
        return 'Лайк + 1';
    }
}
