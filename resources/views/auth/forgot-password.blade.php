<x-layouts.auth title="Forgot Password | FrozenBytes">
    <h1 class="h4 mb-3">Forgot Password</h1>
    <form method="POST" action="{{ route('password.email') }}" class="d-grid gap-3">
        @csrf
        <div>
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Send Reset Link</button>
        <a href="{{ route('login') }}" class="small">Back to login</a>
    </form>
</x-layouts.auth>
