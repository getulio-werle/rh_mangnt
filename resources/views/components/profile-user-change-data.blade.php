<form action="{{ route('user.update_data') }}" method="post">

    @csrf

    <h2>Change user data</h2>

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control">
        @error('name')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email (Username)</label>
        <input type="email" name="email" id="email" class="form-control">
        @error('name')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">Update user data</button>
    </div>

</form>

@if(session('success_change_data'))
    <div class="alert alert-success mt-3">
        {{ session('success_change_data') }}
    </div>
@endif