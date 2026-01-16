@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/modal.css') }}">
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

<main class="main main--with-modal">
    <div class="modal">
        <div class="modal__content">
            <h2 class="modal__title">Weight Logを追加</h2>

            <form class="modal__form" action="{{ route('weight_logs.store') }}" method="POST">
                @csrf
                <div class="modal__form-group">
                    <label class="modal__label" for="date">
                        日付
                        <span class="modal__required">必須</span>
                    </label>
                    <div class="modal__date-wrapper">
                        <input class="modal__input modal__input--date" type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}">
                    </div>
                    @error('date')
                        <p class="modal__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="modal__form-group">
                    <label class="modal__label" for="weight">
                        体重
                        <span class="modal__required">必須</span>
                    </label>
                    <div class="modal__input-wrapper">
                        <input class="modal__input modal__input--with-unit" type="text" id="weight" name="weight" value="{{ old('weight') }}" placeholder="50.0">
                        <span class="modal__unit">kg</span>
                    </div>
                    @error('weight')
                        <p class="modal__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="modal__form-group">
                    <label class="modal__label" for="calories">
                        摂取カロリー
                        <span class="modal__required">必須</span>
                    </label>
                    <div class="modal__input-wrapper">
                        <input class="modal__input modal__input--with-unit" type="text" id="calories" name="calories" value="{{ old('calories') }}" placeholder="1200">
                        <span class="modal__unit">cal</span>
                    </div>
                    @error('calories')
                        <p class="modal__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="modal__form-group">
                    <label class="modal__label" for="exercise_time">
                        運動時間
                        <span class="modal__required">必須</span>
                    </label>
                    <input class="modal__input" type="text" id="exercise_time" name="exercise_time" value="{{ old('exercise_time') }}" placeholder="01:30">
                    @error('exercise_time')
                        <p class="modal__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="modal__form-group">
                    <label class="modal__label" for="exercise_content">運動内容</label>
                    <textarea class="modal__textarea" id="exercise_content" name="exercise_content" placeholder="運動内容を追加">{{ old('exercise_content') }}</textarea>
                    @error('exercise_content')
                        <p class="modal__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="modal__buttons">
                    <a class="modal__button modal__button--back" href="{{ route('weight_logs.index') }}">戻る</a>
                    <button class="modal__button modal__button--submit" type="submit">登録</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
