<x-layout-app page-title="Colaborator details">

    <div class="row">
        <div class="col">

            <h3>Colaborator details</h3>
            <hr>
            <div class="row">
                <div class="col">

                    <p>Name: <strong>{{ $colaborator->name }}</strong></p>
                    <p>Email: <strong>{{ $colaborator->email }}</strong></p>
                    <p>Role: <strong>{{ $colaborator->role }}</strong></p>
                    <p>Permissions: </p>

                    <ul>
                        @foreach (json_decode($colaborator->permissions) as $permission)
                            <li>{{ $permission }}</li>
                        @endforeach
                    </ul>

                    <p>Department: <strong>{{ $colaborator->department->name }}</strong></p>
                    <p>Active:
                        @empty ($colaborator->email_verified_at)
                            <span class="badge bg-danger">No</span>
                        @else
                            <span class="badge bg-success">Yes</span>
                        @endempty
                    </p>
                </div>

                <div class="col">
                    <p>Address: <strong>{{ $colaborator->details->address }}</strong></p>
                    <p>Zip code: <strong>{{ $colaborator->details->zip_code }}</strong></p>
                    <p>City: <strong>{{ $colaborator->details->city }}</strong></p>
                    <p>Phone: <strong>{{ $colaborator->details->phone }}</strong></p>
                    <p>Admission date: <strong>{{ $colaborator->details->admission_date }}</strong></p>
                    <p>Salary: <strong>{{ $colaborator->details->salary }} $</strong></p>
                </div>
            </div>
            <button onclick="window.history.back()" class="btn btn-outline-dark"><i class="fas fa-arrow-left me-2"></i>Back</button>
        </div>
    </div>


</x-layout-app>