<x-layout-app page-title="Add Department">

    <h3>New department</h3>

    <hr>

    <form action="{{ route('department.create_department') }}" method="post">

        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Department name</label>
            <input type="text" class="form-control" id="name" name="name">
            @error('name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <a href="{{ route('departments') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Create department</button>
        </div>

    </form>

</x-layout-app>