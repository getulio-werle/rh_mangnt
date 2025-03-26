<x-layout-guest page-title="Request Password Reset">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-5">
    
                <!-- logo -->
                <div class="text-center mb-5">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" width="200px">
                </div>
    
                <!-- forgot password -->
                <div class="card p-5">

                    @if(!session('status'))
    
                        <p>To recover your password, please enter your email. You will receive an email with a link to recover the password.</p>
        
                        <form action="{{ route('password.email') }}" method="post">
        
                            @csrf

                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>    
                                @enderror
                            </div>
        
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('login') }}">Remember my password?</a>
                                <button type="submit" class="btn btn-primary px-4">Send email</button>
                            </div>
        
                        </form>
                    @else

                        <div class="text-center">
                            <p>A link has been envited to your email. Access the link in email to reset you password.</p>
                            <a href="{{ route('login') }}">Return to login page</a>
                        </div>

                    @endif
    
                </div>
    
            </div>
        </div>
    </div>

</x-layout-guest>