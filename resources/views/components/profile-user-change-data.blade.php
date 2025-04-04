<h2 class="mb-3">Change user data</h2>

<form action="{{ route('user.update-data') }}" method="post">

    @csrf


    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $colaborator->name) }}">
        @error('name')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email (Username)</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $colaborator->email) }}">
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