<x-layouts.auth title="Confirm Password | FrozenBytes">
    <h1 class="h4 mb-3">Confirm Password</h1>
    <form method="POST" action="{{ route('password.confirm') }}" class="d-grid gap-3">
        @csrf
        <div>
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Confirm</button>
    </form>
</x-layouts.auth>
