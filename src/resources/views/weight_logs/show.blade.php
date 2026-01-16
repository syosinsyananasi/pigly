@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endpush

@section('content')
<header class="header">
    <a class="header__logo logo" href="{{ route('weight_logs.index') }}">PiGLy</a>
    <nav class="header__nav">
        <a class="header__nav-button header__nav-button--settings" href="{{ route('weight_logs.goal_setting') }}">
            <i class="fa-solid fa-gear"></i>
            目標体重設定
        </a>
        <form action="{{ route('logout') }}" method="POST" class="header__logout-form">
            @csrf
            <button class="header__nav-button header__nav-button--logout" type="submit">
                <i class="fa-solid fa-right-from-bracket"></i>
                ログアウト
            </button>
        </form>
    </nav>
</header>

<main class="main">
    <div class="detail-card">
        <h2 class="detail-card__title">Weight Log</h2>

        <form class="detail-form" action="{{ route('weight_logs.update', $weightLog) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="detail-form__group">
                <label class="detail-form__label" for="date">日付</label>
                <input class="detail-form__input" type="date" id="date" name="date" value="{{ old('date', $weightLog->date->format('Y-m-d')) }}">
                @error('date')
                    <p class="detail-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="detail-form__group">
                <label class="detail-form__label" for="weight">体重</label>
                <div class="detail-form__input-wrapper">
                    <input class="detail-form__input detail-form__input--with-unit" type="text" id="weight" name="weight" value="{{ old('weight', number_format($weightLog->weight, 1)) }}">
                    <span class="detail-form__unit">kg</span>
                </div>
                @error('weight')
                    <p class="detail-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="detail-form__group">
                <label class="detail-form__label" for="calories">摂取カロリー</label>
                <div class="detail-form__input-wrapper">
                    <input class="detail-form__input detail-form__input--with-unit" type="text" id="calories" name="calories" value="{{ old('calories', $weightLog->calories) }}">
                    <span class="detail-form__unit">cal</span>
                </div>
                @error('calories')
                    <p class="detail-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="detail-form__group">
                <label class="detail-form__label" for="exercise_time">運動時間</label>
                <input class="detail-form__input" type="time" id="exercise_time" name="exercise_time" value="{{ old('exercise_time', \Carbon\Carbon::parse($weightLog->exercise_time)->format('H:i')) }}">
                @error('exercise_time')
                    <p class="detail-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="detail-form__group">
                <label class="detail-form__label" for="exercise_content">運動内容</label>
                <textarea class="detail-form__textarea" id="exercise_content" name="exercise_content" placeholder="運動内容を追加">{{ old('exercise_content', $weightLog->exercise_content) }}</textarea>
                @error('exercise_content')
                    <p class="detail-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="detail-form__buttons">
                <a class="detail-form__button detail-form__button--back" href="{{ route('weight_logs.index') }}">戻る</a>
                <button class="detail-form__button detail-form__button--submit" type="submit">更新</button>
                <button class="detail-form__button detail-form__button--delete" type="button" onclick="document.getElementById('delete-form').submit();">&#128465;</button>
            </div>
        </form>

        <form id="delete-form" action="{{ route('weight_logs.delete', $weightLog) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</main>
@endsection
