<x-layout-app page-title="Profile">

    <div class="row">
        <div class="col-12">

            <h1>Profile</h1>
            
            <hr>

            <div class="d-flex gap-5">
                <p>
                    <i class="fa fa-user"></i>
                    {{ auth()->user()->name }}
                </p>
                <p>
                    <i class="fa fa-user"></i>
                    {{ auth()->user()->role }}
                </p>
                <p>
                    <i class="fa fa-user"></i>
                    {{ auth()->user()->email }}
                </p>
                <p>
                    <i class="fa fa-user"></i>
                    {{ auth()->user()->created_at->format('d/m/Y') }}
                </p>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-6">

            <x-profile-user-change-password />

        </div>
        <div class="col-6">

            <x-profile-user-change-data />

        </div>
    </div>

</x-layout-app>