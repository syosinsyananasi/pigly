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

<main class="main">
    <section class="summary">
        <div class="summary__item">
            <p class="summary__label">目標体重</p>
            <p class="summary__value">{{ $weightTarget ? number_format($weightTarget->target_weight, 1) : '0.0' }}<span class="summary__unit">kg</span></p>
        </div>
        <div class="summary__item summary__item--highlight">
            <p class="summary__label">目標まで</p>
            @php
                $diff = $latestLog && $weightTarget ? $latestLog->weight - $weightTarget->target_weight : 0;
            @endphp
            <p class="summary__value summary__value--diff">{{ $diff >= 0 ? '-' : '+' }}{{ number_format(abs($diff), 1) }}<span class="summary__unit">kg</span></p>
        </div>
        <div class="summary__item">
            <p class="summary__label">最新体重</p>
            <p class="summary__value">{{ $latestLog ? number_format($latestLog->weight, 1) : '0.0' }}<span class="summary__unit">kg</span></p>
        </div>
    </section>

    <div class="content-card">
        <section class="search">
            <form class="search__form" action="{{ route('weight_logs.search') }}" method="GET">
                <div class="search__inputs">
                    <div class="search__date-wrapper">
                        <input class="search__date" type="date" name="from_date" value="{{ $searchFromDate ?? '' }}">
                    </div>
                    <span class="search__separator">～</span>
                    <div class="search__date-wrapper">
                        <input class="search__date" type="date" name="to_date" value="{{ $searchToDate ?? '' }}">
                    </div>
                    <button class="search__button" type="submit">検索</button>
                    @if($isSearching ?? false)
                        <button class="search__reset" type="button" onclick="location.href='{{ route('weight_logs.index') }}'">リセット</button>
                    @endif
                </div>
            </form>
            <button class="search__add-button" type="button" onclick="document.getElementById('create-modal').style.display='flex'">データ追加</button>
        </section>

        @if($isSearching ?? false)
            <p class="search__result-text">{{ $searchFromDate }}～{{ $searchToDate }}の検索結果 {{ $weightLogs->total() }}件</p>
        @endif

        <section class="log-table">
            <table class="log-table__table">
                <thead>
                    <tr class="log-table__header-row">
                        <th class="log-table__header">日付</th>
                        <th class="log-table__header">体重</th>
                        <th class="log-table__header">食事摂取カロリー</th>
                        <th class="log-table__header">運動時間</th>
                        <th class="log-table__header"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($weightLogs as $log)
                        <tr class="log-table__row">
                            <td class="log-table__cell">{{ $log->date->format('Y/m/d') }}</td>
                            <td class="log-table__cell">{{ number_format($log->weight, 1) }}kg</td>
                            <td class="log-table__cell">{{ $log->calories }}cal</td>
                            <td class="log-table__cell">{{ \Carbon\Carbon::parse($log->exercise_time)->format('H:i') }}</td>
                            <td class="log-table__cell log-table__cell--action">
                                <a class="log-table__edit-link" href="{{ route('weight_logs.show', $log) }}"><i class="fa-solid fa-pencil"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr class="log-table__row">
                            <td class="log-table__cell" colspan="5">データがありません</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        @if($weightLogs->hasPages())
            <nav class="pagination">
                @if($weightLogs->onFirstPage())
                    <span class="pagination__link pagination__link--disabled">&lt;</span>
                @else
                    <a class="pagination__link" href="{{ $weightLogs->previousPageUrl() }}">&lt;</a>
                @endif

                @foreach($weightLogs->getUrlRange(1, $weightLogs->lastPage()) as $page => $url)
                    @if($page == $weightLogs->currentPage())
                        <span class="pagination__link pagination__link--current">{{ $page }}</span>
                    @else
                        <a class="pagination__link" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($weightLogs->hasMorePages())
                    <a class="pagination__link" href="{{ $weightLogs->nextPageUrl() }}">&gt;</a>
                @else
                    <span class="pagination__link pagination__link--disabled">&gt;</span>
                @endif
            </nav>
        @endif
    </div>
</main>

<div class="modal" id="create-modal" style="display: {{ $errors->any() ? 'flex' : 'none' }};">
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
                    <input class="modal__input modal__input--with-unit" type="number" step="0.1" inputmode="decimal" id="weight" name="weight" value="{{ old('weight') }}" placeholder="50.0">
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
                    <input class="modal__input modal__input--with-unit" type="number" inputmode="numeric" id="calories" name="calories" value="{{ old('calories') }}" placeholder="1200">
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
                <input class="modal__input" type="time" id="exercise_time" name="exercise_time" value="{{ old('exercise_time') }}" placeholder="01:30">
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
                <button class="modal__button modal__button--back" type="button" onclick="document.getElementById('create-modal').style.display='none'">戻る</button>
                <button class="modal__button modal__button--submit" type="submit">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection
