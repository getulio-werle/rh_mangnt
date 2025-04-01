<x-layout-app pageTitle="Delete department">

    <h3>Delete department</h3>

    <hr>

    <p>Are you sure you want to delete this department?</p>

    <div>
        <h3 class="my-5">{{ $department->name }}</h3>
        <a href="{{ route('departments') }}" class="btn btn-secondary px-5">No</a>
        <a href="{{ route('departments.delete-department-confirm', ['id' => Crypt::encrypt($department->id)]) }}"
            class="btn btn-danger px-5">Yes</a>
    </div>

</x-layout-app>