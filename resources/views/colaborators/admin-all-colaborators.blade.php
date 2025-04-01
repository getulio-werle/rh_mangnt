<x-layout-app page-title="All Colaborators">

    <div class="row">
        <div class="col">

            <h3>All Colaborators</h3>
            <hr>
            @if (count($colaborators) == 0)
                <div class="text-center my-5">
                    <p>No colaborators found.</p>
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
                            <tr>
                                <td>{{ $colaborator->name }}</td>
                                <td>{{ $colaborator->email }}</td>
                                <td>
                                    @empty($colaborator->email_verified_at)
                                        <span class="badge bg-danger">No</span>
                                    @else
                                        <span class="badge bg-success">Yes</span>
                                    @endempty
                                </td>
                                <td>{{ $colaborator->department->name }}</td>
                                <td>{{ $colaborator->role }}</td>
                                <td>{{ $colaborator->details->admission_date }}</td>
                                <td>{{ $colaborator->details->salary }} $</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-end">
                                        <a href="#" class="btn btn-sm btn-outline-dark"><i
                                            class="fas fa-eye me-2"></i>Details</a>
                                            <a href="#" class="btn btn-sm btn-outline-dark"><i
                                                class="fa-regular fa-trash-can me-2"></i>Delete</a>
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