<x-layouts.auth title="Reset Password | FrozenBytes">
    <h1 class="h4 mb-3">Reset Password</h1>
    <form method="POST" action="{{ route('password.update') }}" class="d-grid gap-3">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div>
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $request->email) }}" class="form-control" required>
        </div>
        <div>
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div>
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</x-layouts.auth>
