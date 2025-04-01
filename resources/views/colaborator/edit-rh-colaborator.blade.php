<x-layout-app page-title="Edit RH Colaborator">

    <div class="row">
        <div class="col">

            <h3>Edit Human Resources Colaborator</h3>

            <hr>

            <h4>Colaborator: {{ $colaborator->name }} | {{ $colaborator->email }}</h4>

            <form action="{{ route('rh_colaborators.alter_rh_colaborator') }}" method="post">

                @csrf

                <input type="hidden" name="id" value="{{ Crypt::encrypt($colaborator->id) }}">

                <div class="col-12">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="salary" class="form-label">Salary</label>
                                <input type="number" class="form-control" id="salary" name="salary" step=".01" placeholder="0,00" value="{{ old('salary', $colaborator->details->salary) }}">
                                @error('salary')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="admission_date" class="form-label">Admission Date</label>
                                <input type="text" class="form-control" id="admission_date" name="admission_date" placeholder="YYYY-mm-dd" value="{{ old('admission_date', $colaborator->details->admission_date) }}">
                                @error('admission_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <a href="{{ route('rh_colaborators') }}" class="btn btn-outline-danger me-3">Cancel</a>
                    <button type="submit" class="btn btn-primary">Alter colaborator</button>
                </div>

            </form>

        </div>
    </div>

</x-layout-app>