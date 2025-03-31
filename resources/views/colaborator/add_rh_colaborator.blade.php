<x-layout-app page-title="Add RH Colaborator">

    <div class="row">
        <div class="col">

            <h3>Add Human Resources Colaborator</h3>

            <hr>

            <form action="{{ route('rh_colaborators.create_rh_colaborator') }}" method="post">

                @csrf

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
        
                        <div class="mb-3">
                            <div class="d-flex align-items-end">
                                <div class="flex-grow-1 me-3">
                                    <label for="department" class="form-label">Department</label>
                                    <select name="department" id="department" class="form-select">
                                        @foreach ($departments as $department)
                                            @if ($department->id == 2)
                                                <option value="{{ Crypt::encrypt($department->id) }}">{{ $department->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <a href="{{ route('department.add_department') }}" class="btn btn-primary"><i
                                            class="fa-solid fa-plus"></i></a>
                                </div>
                            </div>
                            @error('department')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="Address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="zip_code" class="form-label">Zip Code</label>
                                    <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code') }}">
                                    @error('zip_code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                                    @error('city')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="salary" class="form-label">Salary</label>
                                    <input type="number" class="form-control" id="salary" name="salary" step=".01" placeholder="0,00" value="{{ old('salary') }}">
                                    @error('salary')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="admission_date" class="form-label">Admission Date</label>
                                    <input type="text" class="form-control" id="admission_date" name="admission_date" placeholder="YYYY-mm-dd" value="{{ old('admission_date') }}">
                                    @error('admission_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="mb-3">Profile: <strong>Human Resources</strong></p>

                <div class="mb-3">
                    <a href="{{ route('rh_colaborators') }}" class="btn btn-outline-danger me-3">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create colaborator</button>
                </div>

            </form>

        </div>
    </div>

</x-layout-app>