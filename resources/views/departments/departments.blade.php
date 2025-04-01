<x-layout-app page-title="Departments">

    <div class="row">
        <div class="col">

            <h3>Departments</h3>

            <hr>

            @if (count($departments) == 0)
                <div class="text-center my-5">
                    <p>No departments found.</p>
                    <a href="{{ route('departments.add-department') }}" class="btn btn-primary">Create a new department</a>
                </div>
            @else
                <div class="mb-3">
                    <a href="{{ route('departments.add-department') }}" class="btn btn-primary">Create a new department</a>
                </div>
                <table class="table" id="table">
                    <thead class="table-dark">
                        <th>Departments</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                            <tr>
                                <td>{{ $department->name }}</td>
                                <td>
                                    @if(in_array($department->id, [1, 2]))
                                        <div class="d-flex gap-3 justify-content-end">
                                            <i class="fa fa-lock"></i>
                                        </div>
                                    @else
                                        <div class="d-flex gap-3 justify-content-end">
                                            <a href="{{ route('departments.edit-department', ['id' => Crypt::encrypt($department->id) ]) }}" class="btn btn-sm btn-outline-dark"><i
                                                    class="fa-regular fa-pen-to-square me-2"></i>Edit</a>
                                            <a href="{{ route('departments.delete-department', ['id' => Crypt::encrypt($department->id) ]) }}" class="btn btn-sm btn-outline-dark"><i
                                                    class="fa-regular fa-trash-can me-2"></i>Delete</a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>

</x-layout-app>