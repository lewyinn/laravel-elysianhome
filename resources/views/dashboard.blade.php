<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>

    @if (auth()->user()->role === 'admin')
        <p>Anda adalah Admin.</p>
        <a href="/admin-only">Halaman Khusus Admin</a>
    @elseif (auth()->user()->role === 'user')
        <p>Anda adalah User.</p>
        <a href="/user-only">Halaman Khusus User</a>
    @endif

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
