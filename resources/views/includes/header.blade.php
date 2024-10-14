<nav class="navbar navbar-expand-md bg-body-tertiary">
    <div class="container">
      <a href="{{ route('home') }}" class="navbar-brand">{{ config('app.name') }}</a>
      <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar-collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar-collapse">
        @php
          function active_link(string $name, string $active = 'active'): string {
              return Route::is($name) ? $active : '';
          }
        @endphp
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{active_link('home') }}" aria-current="page" >
                {{ __('Главная')}}
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('blog.index') }}" class="nav-link {{ active_link('blog*') }}" aria-current="page" >
                {{ __('Блог')}}
            </a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-md-0">

          @auth
          <li class="nav-item">
            <span class="nav-link">{{ auth()->user()->name }}: </span>
          </li>
          <li class="nav-item">
            <a href="{{ route('user') }}" class="nav-link {{ active_link('user')}}" aria-current="page" >{{ __('Мои посты')}}</a>
          </li>
          <li class="nav-item">
            <form action=" {{ route('logout') }}" method="post">
              @csrf
              <button class="nav-link">Выйти</button>
            </form>
          </li>

          @endauth

          @guest
            <li class="nav-item">
              <a href="{{ route('register') }}" class="nav-link {{ active_link('register')}}" aria-current="page" >{{ __('Регистрация')}}</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('login') }}" class="nav-link {{ active_link('login')}}" aria-current="page" >{{ __('Вход')}}</a>
            </li>
          @endguest

        </ul>
      </div>
    </div>
  </nav>