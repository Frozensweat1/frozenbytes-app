<x-layouts.auth title="Two Factor Challenge | FrozenBytes">
    <h1 class="h4 mb-3">Two Factor Authentication</h1>
    <form method="POST" action="{{ route('two-factor.login') }}" class="d-grid gap-3">
        @csrf
        <div>
            <label class="form-label">Authentication Code</label>
            <input type="text" name="code" class="form-control">
        </div>
        <div>
            <label class="form-label">Recovery Code</label>
            <input type="text" name="recovery_code" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Verify</button>
    </form>
</x-layouts.auth>
