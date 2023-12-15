<!DOCTYPE html>
<html>

<head>
    <title>Registration Page</title>
    @include('top_nav_bar')
    <style>
        
        .content-background {
            position: absolute;
            left: -100%;
            width: 100%;
            height: 1000px;
            background-image: url('{{ asset('login_background.png') }}');
            background-color: #2a57dd;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            animation: slideIn 2s forwards; /* Slide in the content once */
            opacity: 0.8;
            z-index: -1;
            pointer-events: none;
        }

        @keyframes slideIn {
            from { left: -100%; }
            to { left: 0; }
        }

        .card {
            border: 2px solid #000000;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }


        /* Custom CSS for controlling the width of the card */
        .smaller-card {
            max-width: 500px;
            margin: 0 auto;
            padding: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .input-group-prepend .input-group-text {
            background-color: #FEFBFB;
        }
        .error-message {
            color: #ff0000; 
            font-size: 14px; 
            margin-top: 5px; 
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content-background"></div>
        <div class="row justify-content-center register-form">
            <div class="col-md-8">
                <img src="{{ asset('donate_icon.png') }}" alt="Donate Icon" class="mx-auto d-block mb-4" />
                <div class="card smaller-card my-4">
                    <div class="card-header">Register</div>
                    <div class="card-body text-center">
                        <form method="POST" action="{{ route('register.submit') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group has-validation">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" required autocomplete="first_name"  aria-describedby="inputGroupPrepend">
                                    </div>
                                    
                                    @error('first_name')
                                    <span class="error-message " role="alert">
                                        <i class="bi bi-exclamation-circle-fill"></i> <strong> {{ $message }} </strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" required autocomplete="last_name">
                                    </div>
                                    @error('last_name')
                                    <span class="error-message" role="alert">
                                        <i class="bi bi-exclamation-circle-fill"></i> <strong> {{ $message }} </strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                        </div>
                                        <input id="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" placeholder="e.g., +601126336850" value="{{ old('contact_number') }}" required autocomplete="contact_number">
                                    </div>
                                    @error('contact_number')
                                    <span class="error-message" role="alert">
                                        <i class="bi bi-exclamation-circle-fill"></i> <strong> {{ $message }} </strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                        </div>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                                    </div>
                                    @error('email')
                                    <span class="error-message " role="alert">
                                        <i class="bi bi-exclamation-circle-fill"></i> <strong> {{ $message }} </strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                                        </div>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" onclick="togglePassword('password')">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('password')
                                    <span class="error-message " role="alert">
                                        <i class="bi bi-exclamation-circle-fill"></i> <strong> {{ $message }} </strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        </div>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" onclick="togglePassword('password-confirm')">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-user-plus"></i>  Register
                                    </button>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-md-12">Already got account? Login <a href="{{ route('login.form') }}">here</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<footer>
    @include('bot_nav_bar')
</footer>

</html>
<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.querySelector(`[onclick="togglePassword('${inputId}')"] i`);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>