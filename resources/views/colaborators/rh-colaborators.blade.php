<x-layout-app page-title="Human Resources Colaborators">

    <div class="row">
        <div class="col">
            <h3>Human Resources Colaborators</h3>
            <hr>
            @if (count($colaborators) == 0)
                <div class="text-center my-5">
                    <p>No colaborators found.</p>
                    <a href="{{ route('colaborators.rh.add-colaborator') }}" class="btn btn-primary">Add a new colaborator</a>
                </div>
            @else
                <div class="mb-3">
                    <a href="{{ route('colaborators.rh.add-colaborator') }}" class="btn btn-primary">Add a new colaborator</a>
                </div>
                <table class="table" id="table">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Active</th>
                            <th>Department</th>
                            <th>Role</th>
                            <th>Admission date</th>
                            <th>Salary</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($colaborators as $colaborator)
                            <tr class="{{ $colaborator->deleted_at != null ? 'table-danger' : '' }}">
                                <td>{{ $colaborator->name }}</td>
                                <td>{{ $colaborator->email }}</td>
                                <td>
                                    @empty($colaborator->email_verified_at)
                                        <span class="badge bg-danger">No</span>
                                    @else
                                        <span class="badge bg-success">Yes</span>
                                    @endempty
                                </td>
                                <td>{{ $colaborator->department->name ?? '-' }}</td>
                                <td>{{ $colaborator->role }}</td>
                                <td>{{ $colaborator->details->admission_date }}</td>
                                <td>{{ $colaborator->details->salary }} $</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-end">
                                        @empty($colaborator->deleted_at)
                                            <a href="{{ route('colaborators.rh.edit-colaborator', ['id' => Crypt::encrypt($colaborator->id)]) }}" class="btn btn-sm btn-outline-dark"><i
                                                    class="fa-regular fa-pen-to-square me-2"></i>Edit</a>
                                            <a href="{{ route('colaborators.rh.delete-colaborator', ['id' => Crypt::encrypt($colaborator->id)]) }}" class="btn btn-sm btn-outline-dark"><i
                                                    class="fa-regular fa-trash-can me-2"></i>Delete</a>
                                        @else
                                            <a href="{{ route('colaborators.rh.restore-colaborator', ['id' => Crypt::encrypt($colaborator->id)]) }}" class="btn btn-sm btn-outline-dark"><i
                                                class="fa-solid fa-trash-arrow-up me-2"></i>Restore</a>
                                        @endempty
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</x-layout-app>