<h2 class="mb-3">Change password</h2>

<form action="{{ route('user.update-password') }}" method="post">

    @csrf

    <div class="mb-3">
        <label for="current_password" class="form-label">Current password</label>
        <input type="password" name="current_password" id="current_password" class="form-control">
        @error('current_password')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="new_password" class="form-label">New password</label>
        <input type="password" name="new_password" id="new_password" class="form-control">
        @error('new_password')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="new_password_confirmation" class="form-label">Confirm new password</label>
        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control">
        @error('new_password_confirmation')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">Change password</button>
    </div>

</form>

@if(session('error_change_password'))
    <div class="alert alert-danger mt-3">
        {{ session('error_change_password') }}
    </div>
@endif

@if(session('success_change_password'))
    <div class="alert alert-success mt-3">
        {{ session('success_change_password') }}
    </div>
@endif