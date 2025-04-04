<x-layout-app page-title="Profile">

    <div class="row mb-5">
        <div class="col-12">

            <h1>Profile</h1>
            
            <hr>

            <div class="d-flex gap-5 flex-wrap">
                <p>
                    <i class="fa fa-user"></i>
                    Name:
                    {{ auth()->user()->name }}
                </p>
                <p>
                    <i class="fa fa-user"></i>
                    Role:
                    {{ auth()->user()->role }}
                </p>
                <p>
                    <i class="fa fa-user"></i>
                    Email:
                    {{ auth()->user()->email }}
                </p>
                <p>
                    <i class="fa fa-user"></i>
                    Created at:
                    {{ auth()->user()->created_at->format('d/m/Y') }}
                </p>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-4 mb-3">

            <x-profile-user-change-password />

        </div>
        <div class="col-12 col-md-4 mb-3">

            <x-profile-user-change-data :colaborator="$colaborator" />

        </div>
        <div class="col-12 col-md-4 mb-3">

            <x-profile-user-change-address :colaborator="$colaborator" />

        </div>
    </div>

</x-layout-app>