<x-layouts.auth title="Register | FrozenBytes">
    <h1 class="h4 mb-3">Create Account</h1>
    <form method="POST" action="{{ route('register') }}" class="d-grid gap-3">
        @csrf
        <div>
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div>
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div>
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div>
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <a href="{{ route('login') }}" class="small">Already have an account?</a>
    </form>
</x-layouts.auth>
