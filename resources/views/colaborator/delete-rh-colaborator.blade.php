<x-layout-app pageTitle="Delete colaborator">

    <h3>Delete colaborator</h3>

    <hr>

    <p>Are you sure you want to delete this colaborator?</p>

    <div>
        <h3 class="my-5">{{ $colaborator->name }} | {{ $colaborator->email }}</h3>
        <a href="{{ route('rh_colaborators') }}" class="btn btn-secondary px-5">No</a>
        <a href="{{ route('rh_colaborators.delete_rh_colaborator_confirm', ['id' => Crypt::encrypt($colaborator->id)]) }}"
            class="btn btn-danger px-5">Yes</a>
    </div>

</x-layout-app>