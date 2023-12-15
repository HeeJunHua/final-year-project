<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    @include('top_nav_bar')
    <style>

        .content-background {
            position: absolute;
            left: -100%;
            width: 100%;
            height: 740px;
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

        .login-form {
            min-height: 621px;
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
        
        
    </style>
</head>

<body>

    @if ($errors->has('login'))
        <div class="alert alert-danger" style="margin-bottom: 0px;" id="wrongCredentialAlert">
            {{ $errors->first('login') }}
        </div>
    @endif
    <div class="container">
        <div class="content-background"></div>
        <div class="row justify-content-center login-form">
            <div class="col-md-8">
                <img src="{{ asset('donate_icon.png') }}" alt="Donate Icon" class="mx-auto d-block mb-4" />
                <div class="card smaller-card  my-4">
                <div class="card-header">Login</div>
                    <div class="card-body text-center">
                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                        </div>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                                        </div>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">No account? Register <a href="{{ route('register') }}">here</a>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-7 offset-3">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-sign-in"></i> Login
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <a class="btn btn-link" href="#">
                                        <i class="fa fa-question-circle"></i> Forgot Your Password?
                                    </a>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Set a timer to fade out the alert after 3 seconds (3000 milliseconds)
    $(document).ready(function() {
        setTimeout(function() {
            $('#wrongCredentialAlert').fadeOut();
        }, 1000); // Adjust the duration as needed
    });

    $(document).ready(function() {
        // Get the password input and the eye icon
        var passwordInput = document.getElementById('password');
        var togglePassword = document.getElementById('togglePassword');

        // Add a click event listener to the eye icon
        togglePassword.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePassword.classList.remove('fa-eye');
                togglePassword.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                togglePassword.classList.remove('fa-eye-slash');
                togglePassword.classList.add('fa-eye');
            }
        });
    });
</script>