<x-layout-app page-title="Edit Department">

    <h3>Edit department</h3>

    <hr>

    <form action="{{ route('departments.alter-department') }}" method="post">

        @csrf

        <input type="hidden" name="id" value="{{ Crypt::encrypt($department->id) }}">

        <div class="mb-3">
            <label for="name" class="form-label">Department name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $department->name }}">
            @error('name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <a href="{{ route('departments') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Alter department</button>
        </div>

    </form>

</x-layout-app>