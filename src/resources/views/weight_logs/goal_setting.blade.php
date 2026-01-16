@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/goal.css') }}">
@endpush

@section('content')
<header class="header">
    <a class="header__logo" href="{{ route('weight_logs.index') }}">PiGLy</a>
    <nav class="header__nav">
        <a class="header__nav-button header__nav-button--settings header__nav-button--active" href="{{ route('weight_logs.goal_setting') }}">
            <span class="header__nav-icon">&#9881;</span>
            目標体重設定
        </a>
        <form action="{{ route('logout') }}" method="POST" class="header__logout-form">
            @csrf
            <button class="header__nav-button header__nav-button--logout" type="submit">
                <span class="header__nav-icon">&#10145;</span>
                ログアウト
            </button>
        </form>
    </nav>
</header>

<main class="main main--center">
    <div class="goal-card">
        <h2 class="goal-card__title">目標体重設定</h2>

        <form class="goal-form" action="{{ route('weight_logs.goal_setting.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="goal-form__group">
                <div class="goal-form__input-wrapper">
                    <input class="goal-form__input" type="text" id="target_weight" name="target_weight" value="{{ old('target_weight', $weightTarget ? number_format($weightTarget->target_weight, 1) : '') }}">
                    <span class="goal-form__unit">kg</span>
                </div>
                @error('target_weight')
                    <p class="goal-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="goal-form__buttons">
                <a class="goal-form__button goal-form__button--back" href="{{ route('weight_logs.index') }}">戻る</a>
                <button class="goal-form__button goal-form__button--submit" type="submit">更新</button>
            </div>
        </form>
    </div>
</main>
@endsection
