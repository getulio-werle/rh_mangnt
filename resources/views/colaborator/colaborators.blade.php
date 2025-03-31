<x-layout-app page-title="Human Resources Colaborators">

    <div class="row">
        <div class="col">

            <h3>Human Resources Colaborators</h3>
            <hr>
            @if (count($colaborators) == 0)
                <div class="text-center my-5">
                    <p>No colaborators found.</p>
                    <a href="{{ route('rh_colaborators.add_rh_colaborator') }}" class="btn btn-primary">Add a new colaborator</a>
                </div>
            @else
                <div class="mb-3">
                    <a href="{{ route('rh_colaborators.add_rh_colaborator') }}" class="btn btn-primary">Add a new colaborator</a>
                </div>
                <table class="table w-50" id="table">
                    <thead class="table-dark">
                        <tr>
                            <th>Colaborators</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Permissions</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($colaborators as $colaborator)
                            <tr>
                                <td>{{ $colaborator->name }}</td>
                                <td>{{ $colaborator->email }}</td>
                                @php
                                    $permissions = json_decode($colaborator->permissions)
                                @endphp
                                <td>{{ implode(',', $permissions) }}</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-end">
                                        <a href="#" class="btn btn-sm btn-outline-dark"><i
                                                class="fa-regular fa-pen-to-square me-2"></i>Edit</a>
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