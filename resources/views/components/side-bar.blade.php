<div class="d-flex flex-column sidebar h-100 p-5 bg-light shadow-sm">
    <a href="{{ route('home') }}"><i class="fas fa-house me-3"></i>Home</a>
    @can('admin')
        <a href="{{ route('colaborators') }}"><i class="fas fa-users me-3"></i>Geral Colaborators</a>
        <a href="{{ route('colaborators.rh') }}"><i class="fas fa-users me-3"></i>RH Colaborators</a>
        <a href="{{ route('departments') }}"><i class="fas fa-building me-3"></i>Departments</a>
    @endcan
    <hr>
    <a href="{{ route('user.profile') }}"><i class="fas fa-user-gear me-3"></i>User Profile</a>
</div>