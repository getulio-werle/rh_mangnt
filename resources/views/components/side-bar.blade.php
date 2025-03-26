<div class="d-flex flex-column sidebar p-5 bg-light shadow-sm">
    <a href="#"><i class="fas fa-house me-3"></i>Home</a>
    @can('admin')
        <a href="#"><i class="fas fa-users me-3"></i>Geral Colaborators</a>
        <a href="#"><i class="fas fa-users me-3"></i>RH Colaborators</a>
        <a href="#"><i class="fas fa-building me-3"></i>Departments</a>
    @endcan
    <a href="#"><i class="fas fa-user-gear me-3"></i>User Profile</a>
</div>