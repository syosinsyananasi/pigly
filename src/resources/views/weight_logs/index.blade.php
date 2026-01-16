@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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

    <section class="search">
        <form class="search__form" action="{{ route('weight_logs.search') }}" method="GET">
            <div class="search__inputs">
                <input class="search__date" type="date" name="from_date" value="{{ $searchFromDate ?? '' }}">
                <span class="search__separator">～</span>
                <input class="search__date" type="date" name="to_date" value="{{ $searchToDate ?? '' }}">
                <button class="search__button" type="submit">検索</button>
                @if($isSearching ?? false)
                    <button class="search__reset" type="button" onclick="location.href='{{ route('weight_logs.index') }}'">リセット</button>
                @endif
            </div>
        </form>
        <a class="search__add-button" href="{{ route('weight_logs.create') }}">データ追加</a>
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
</main>
@endsection
