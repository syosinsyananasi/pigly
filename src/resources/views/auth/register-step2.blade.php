@extends('layouts.auth')

@section('content')
<div class="auth-card">
    <h1 class="auth-card__logo">PiGLy</h1>
    <h2 class="auth-card__title">新規会員登録</h2>
    <p class="auth-card__step">STEP2 体重データの入力</p>

    <form class="auth-form" action="{{ route('register.step2.store') }}" method="POST">
        @csrf
        <div class="auth-form__group">
            <label class="auth-form__label" for="current_weight">現在の体重</label>
            <div class="auth-form__input-wrapper">
                <input class="auth-form__input auth-form__input--with-unit" type="text" id="current_weight" name="current_weight" value="{{ old('current_weight') }}" placeholder="現在の体重を入力">
                <span class="auth-form__unit">kg</span>
            </div>
            @error('current_weight')
                <p class="auth-form__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-form__group">
            <label class="auth-form__label" for="target_weight">目標の体重</label>
            <div class="auth-form__input-wrapper">
                <input class="auth-form__input auth-form__input--with-unit" type="text" id="target_weight" name="target_weight" value="{{ old('target_weight') }}" placeholder="目標の体重を入力">
                <span class="auth-form__unit">kg</span>
            </div>
            @error('target_weight')
                <p class="auth-form__error">{{ $message }}</p>
            @enderror
        </div>

        <button class="auth-form__button" type="submit">アカウント作成</button>
    </form>
</div>
@endsection
