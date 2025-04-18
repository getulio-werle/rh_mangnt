<x-layout-app page-title="Delete colaborator">

    <h3>Delete colaborator</h3>

    <hr>

    <p>Are you sure you want to delete this colaborator?</p>

    <div class="text-center">
        <h3 class="my-3">{{ $colaborator->name }}</h3>
        <p class="mb-5">{{ $colaborator->email }}</p>
        @if ($colaborator->role == 'rh')
            <a href="{{ route('colaborators.rh') }}" class="btn btn-secondary px-5">No</a>
            <a href="{{ route('colaborators.rh.delete-colaborator-confirm', ['id' => Crypt::encrypt($colaborator->id)]) }}"
                class="btn btn-danger px-5">Yes</a>
        @else
            <a href="{{ route('colaborators') }}" class="btn btn-secondary px-5">No</a>
            <a href="{{ route('colaborators.delete-colaborator-confirm', ['id' => Crypt::encrypt($colaborator->id)]) }}"
                class="btn btn-danger px-5">Yes</a>
        @endif
    </div>

</x-layout-app>