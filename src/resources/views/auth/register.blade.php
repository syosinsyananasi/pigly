@extends('layouts.auth')

@section('content')
<div class="auth-card">
    <h1 class="auth-card__logo">PiGLy</h1>
    <h2 class="auth-card__title">新規会員登録</h2>
    <p class="auth-card__step">STEP1 アカウント情報の登録</p>

    <form class="auth-form" action="/register" method="POST">
        @csrf
        <div class="auth-form__group">
            <label class="auth-form__label" for="name">お名前</label>
            <input class="auth-form__input" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="名前を入力">
            @error('name')
                <p class="auth-form__error">{{ $message }}</p>
            @enderror
        </div>

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
            <button class="auth-form__button" type="submit">次に進む</button>
        </div>
    </form>

    <a class="auth-card__link" href="{{ route('login') }}">ログインはこちら</a>
</div>
@endsection
