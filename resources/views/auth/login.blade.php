<x-layouts.auth title="Login | FrozenBytes">
    <h1 class="h4 mb-3">Sign In</h1>
    <form method="POST" action="{{ route('login') }}" class="d-grid gap-3">
        @csrf
        <div>
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>
        <div>
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="{{ route('password.request') }}" class="small">Forgot password?</a>
        <a href="{{ route('register') }}" class="small">Create an account</a>
    </form>
</x-layouts.auth>
