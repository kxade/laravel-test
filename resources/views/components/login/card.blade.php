<x-card>
    <x-card-header>
        <x-card-title>

            {{ __('Вход') }}

        </x-card-title>
        <x-slot name="right">
            <a href="{{ route('register') }}">
                {{ __('Регистрация') }}
            </a>                
        </x-slot>
    </x-card-header>

    <x-card-body>
        <x-form action="{{ route('login.store')}}" method="POST">
            <x-form-item>
                <x-label required>
                    {{ __('E-mail') }}
                </x-label>         
                <x-input type="email" name="email" autofocus/>
            </x-form-item>

            <x-form-item> 
                <x-label required>
                    {{ __('Пароль') }}
                </x-label>  
                <x-input type="password" name="password"/>
            </x-form-item>

            <x-form-item>
                <x-checkbox name="remember">
                    {{ __('Запомнить меня') }}
                </x-checkbox> 
            </x-form-item>
            
            <x-error name="failed"/>

            <x-button type="submit" color="success">
                {{ __('Войти') }}
            </x-button>
        </x-form>
    </x-card-body>
</x-card>