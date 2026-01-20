<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PiGLy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @stack('styles')
</head>
<body>
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
    @yield('content')
    @stack('scripts')
</body>
</html>
