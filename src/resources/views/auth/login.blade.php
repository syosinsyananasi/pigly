@extends('layouts.auth')

@section('content')
<div class="auth-card">
    <h1 class="auth-card__logo">PiGLy</h1>
    <h2 class="auth-card__title">ログイン</h2>

    <form class="auth-form" action="{{ route('login') }}" method="POST" novalidate>
        @csrf
        <div class="auth-form__group">
            <label class="auth-form__label" for="email">メールアドレス</label>
            <input class="auth-form__input" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力">
            @error('email')
                <p class="auth-form__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-form__group">
            <label class="auth-form__label" for="password">パスワード</label>
            <input class="auth-form__input" type="password" id="password" name="password" placeholder="パスワードを入力">
            @error('password')
                <p class="auth-form__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-form__button-wrapper">
            <button class="auth-form__button" type="submit">ログイン</button>
        </div>
    </form>

    <a class="auth-card__link" href="{{ route('register.step1') }}">アカウント作成はこちら</a>
</div>
@endsection
