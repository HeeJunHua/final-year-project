<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <style>

        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
            bottom: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }

        .footer .social-icons a {
            margin: 5px 15px; /* Adjust the margin */
            font-size: 25px; /* Adjust the icon size */
        }
        
        .footer-divider {
            width: 100%;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            margin: 10px 0;
        }

        .col-3 {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .col-3 .input-group {
            width: 100%;
        }

        .newsletter-hint {
            font-size: 12px;
            color: #aaa;
            margin-top: 5px;
        }

    </style>
</head>
<footer class="footer bg-dark text-light">
    <div class="container">
        <div class="row ">
            <div class="col-3">
                <h5>Follow us on social media :</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light"><i class="fab fa-facebook"></i> Facebook</a></li>
                    <li><a href="#" class="text-light"><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><a href="#" class="text-light"><i class="fab fa-twitter"></i> Twitter</a></li>
                    <li><a href="#" class="text-light"><i class="bi bi-discord"></i> Discord</a></li>
                </ul>
            </div>
            <div class="col-3">
                <h5>Contact Info</h5>
                <div>heejunhua1231@gmail.com <br> +601126336700</div>
            </div>
            <div class="col-3">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('fundraise_home_page')}}" class="text-light">Home</a></li>
                    <li><a href="{{ route('about-us')}}" class="text-light">About Us</a></li>
                    <li><a href="mailto:heejunhua1231@gmail.com" class="text-light">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-3">
                <h5>Don't Miss a Thing</h5>
                <h6>Join our newsletter for more info</h6>
                {{-- <div class="input-group">
                    <input type="email" class="form-control" placeholder="Your Email">
                    <div class="input-group-append">
                        <button class="btn btn-outline-light" type="button">Subscribe</button>
                    </div>
                </div>
                <div class="newsletter-hint">Your email is safe with us, we don't spam.</div> --}}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="footer-divider"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                Copyright &copy; 2024 Fundraising & Food Waste Reduction
            </div>
        </div>
    </div>
</footer>
</html>