<h2 class="mb-3">Change user address</h2>

<form action="{{ route('user.update-address')}}" method="post">

    @csrf

    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label for="Address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $colaborator->details->address) }}">
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label for="zip_code" class="form-label">Zip Code</label>
                <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code', $colaborator->details->zip_code) }}">
                @error('zip_code')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $colaborator->details->city) }}">
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
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $colaborator->details->phone) }}">
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="salary" class="form-label">Salary</label>
                <input type="" class="form-control" id="salary" name="salary" step=".01" placeholder="0,00"
                    value="{{ $colaborator->details->salary }}" readonly>
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="admission_date" class="form-label">Admission Date</label>
                <input type="text" class="form-control" id="admission_date" name="admission_date"
                    placeholder="YYYY-mm-dd" value="{{ $colaborator->details->admission_date }}" readonly>
            </div>
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">Update user address</button>
    </div>

</form>

@if(session('success_change_address'))
    <div class="alert alert-success mt-3">
        {{ session('success_change_address') }}
    </div>
@endif