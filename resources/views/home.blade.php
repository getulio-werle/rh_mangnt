<x-layout-app page-title="Home">
    
    <h1>Home</h1>
    <hr>
    @can('admin')
    <div class="d-flex gap-5 flex-wrap">
        <x-info-title-value title="Total Colaborators" :value="$data['total_colaborators']" />
        <x-info-title-value title="Total Deleted Colaborators" :value="$data['total_colaborators_deleted']" />
        <x-info-title-value title="Total Salary" :value="$data['total_salary']" />
        <x-info-title-collection title="Total Colaborators Per Department" :collection="$data['total_colaborators_per_department']" />
        <x-info-title-collection title="Total Salary By Department" :collection="$data['total_salary_by_department']" />
    </div>
    @else
        <p>Welcome!</p>
    @endcan

</x-layout-app>
