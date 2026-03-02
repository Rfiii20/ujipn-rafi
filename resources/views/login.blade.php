    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
        <title>Login</title>
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    </head>

    <body>

        <div class="login-wrapper">
            <div class="login-card">
                <img src="{{ asset('img/logo.png') }}" class="logo">

                <h2>Login</h2>
                <p>Sarana & Prasarana</p>

                @if (session('error'))
                    <div class="error">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <label>Email</label>
                    <input type="email" name="email" placeholder="Masukkan Email" required autofocus>

                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password" required>

                    <button type="submit">Login</button>
                </form>
            </div>
        </div>

    </body>

    </html>
