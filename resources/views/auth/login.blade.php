<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="https://efsm.safefoodmitra.com/admin/public/Save Food Mitra logo.jpg" type="image/png">
    <title>HACCP Pro Admin - Login</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #28a745;
            --accent-color: #ffc107;
            --dark-color: #343a40; 
            --hero-dark-color: #1a3e6f; 
            --card-bg: #ffffff;
            --card-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            --input-border-color: #ced4da;
            --input-focus-border-color: var(--primary-color);
            --text-color: #495057;
            --text-muted-color: #6c757d;
            --transition: all 0.3s ease;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            /* REMOVED GRADIENT OVERLAY FROM background-image */
            background-image: url('https://images.unsplash.com/photo-1606787366850-de6330128bfc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            /* background-blend-mode: overlay; */ /* Removed/commented out as there's no second layer to blend */
            background-size: cover;
            background-position: center;
            background-attachment: fixed; 

            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            overflow-x: hidden;
        }
        
        .login-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .login-card {
            background: var(--card-bg); 
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            width: 100%;
            max-width: 400px; 
            overflow: hidden;
            border: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column; 
        }

        .login-hero {
            padding: 20px 25px 15px;
            text-align: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            position: relative; 
        }

        .logo-container { 
            margin-bottom: 10px;
            display: inline-block; 
            background: white;
            padding: 5px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .login-logo { 
            width: 70px;
            height: auto;
            object-fit: contain;
        }
        .hero-title { 
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2px;
        }
        .hero-text, .features-list,
        .login-hero::before, .login-hero::after { 
            display: none;
        }
        
        .login-form { 
            padding: 20px 25px;
            background: transparent; 
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-title { 
            color: var(--dark-color);
            margin-bottom: 15px;
            font-weight: 600;
            font-size: 1.3rem; 
            text-align: center;
            position: relative; 
        }
        .form-title::after { 
            content: ''; position: absolute; bottom: -5px; left: 50%;
            transform: translateX(-50%); width: 40px; height: 2px;
            background: var(--primary-color); border-radius: 3px;
            opacity: 0.7;
        }

        .form-subtitle { 
            color: var(--text-muted-color);
            margin-bottom: 15px;
            font-weight: 400;
            font-size: 0.9rem;
            text-align: center;
        }
        
        .login-method-tabs {
            display: flex; margin-bottom: 15px; border-radius: 8px;
            background-color: #f8f9fa; padding: 4px;
        }
        .login-tab {
            flex-grow: 1; padding: 8px 10px; cursor: pointer; font-weight: 500;
            color: var(--text-muted-color); transition: var(--transition); text-align: center;
            font-size: 0.9rem; border-radius: 6px;
        }
        .login-tab.active {
            color: #fff; background-color: var(--primary-color);
            box-shadow: 0 2px 5px rgba(0, 123, 255, 0.3);
        }
        .login-tab:not(.active):hover { color: var(--primary-color); }
        
        .login-method-content { display: none; }
        .login-method-content.active { display: block; animation: fadeIn 0.5s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .form-group { margin-bottom: 12px; position: relative; }
        .form-label {
            display: block; margin-bottom: 5px; font-weight: 500;
            color: var(--text-muted-color); font-size: 0.85rem;
        }
        
        .form-control {
            width: 100%; padding: 10px 12px; padding-left: 35px;
            border: 1px solid var(--input-border-color); border-radius: 6px;
            font-size: 0.95rem; transition: var(--transition); background-color: #fdfdff;
        }
        .form-control:focus {
            border-color: var(--input-focus-border-color);
            box-shadow: 0 0 0 2px rgba(var(--bs-primary-rgb),0.25);
            outline: none;
        }
        
        .input-icon {
            position: absolute; left: 12px; top: 35px;
            color: var(--text-muted-color); font-size: 0.9rem; transition: color 0.3s ease;
        }
        .form-control:focus ~ .input-icon { color: var(--primary-color); }
        
        .password-toggle {
            position: absolute; right: 12px; top: 35px;
            cursor: pointer; color: var(--text-muted-color); font-size: 0.9rem;
        }
        .password-toggle:hover { color: var(--primary-color); }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white; border: none; padding: 10px;
            border-radius: 6px; font-size: 1rem; font-weight: 500;
            cursor: pointer; transition: var(--transition); margin-top: 10px;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%;
        }
        .btn-login:hover { opacity: 0.9; box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3); }
        
        .forgot-password { text-align: right; margin-top: 8px; margin-bottom: 15px; }
        .forgot-password a {
            color: var(--primary-color); text-decoration: none;
            font-size: 0.8rem; transition: var(--transition);
        }
        .forgot-password a:hover { text-decoration: underline; opacity: 0.8; }
        
        .mpin-input-container { display: flex; justify-content: space-between; margin-bottom: 12px; gap: 5px; }
        .mpin-input {
            flex: 1; min-width: 30px; max-width: 40px; height: 40px;
            text-align: center; font-size: 1.2rem;
            border: 1px solid var(--input-border-color); border-radius: 6px;
            transition: var(--transition); background-color: #fdfdff;
        }
        .mpin-input:focus {
            border-color: var(--input-focus-border-color);
            box-shadow: 0 0 0 2px rgba(var(--bs-primary-rgb),0.25); outline: none;
        }
        
        .loader {
            display: none; width: 18px; height: 18px; border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%; border-top-color: white; animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        
        .animate-pop { animation: popIn 0.6s ease-out; }
        @keyframes popIn {
            0% { transform: scale(0.9); opacity: 0; }
            80% { transform: scale(1.05); }
            100% { transform: scale(1); opacity: 1; }
        }

        .input-focus-effect { position: relative; } 
        .input-focus-effect::after {
            content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            transition: var(--transition);
        }
        .input-focus-effect:focus-within::after { width: 100%; }
        
        .modal {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6); z-index: 1000; justify-content: center; align-items: center;
            padding: 15px;
        }
        .modal-content {
            background-color: var(--card-bg); padding: 20px;
            border-radius: 12px; width: 100%; max-width: 400px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); position: relative;
            animation: modalFadeIn 0.3s ease-out;
        }
         @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95) translateY(-10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .close-modal {
            position: absolute; top: 10px; right: 15px; font-size: 1.8rem; color: var(--text-muted-color);
            cursor: pointer; transition: var(--transition); line-height: 1;
        }
        .close-modal:hover { color: var(--primary-color); }
        .modal-title {
            color: var(--dark-color); margin-bottom: 15px; font-size: 1.2rem; font-weight: 600; text-align: center;
        }
        .modal-logo { width: 60px; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto; }
        .modal .form-group { margin-bottom: 15px; }
        .modal .form-control { font-size: 0.9rem; padding: 10px 12px; padding-left: 35px; }
        .modal .input-icon { top: 33px; } 
        .modal .btn-login { width: 100%; font-size: 0.95rem; }
        .modal p {font-size: 0.85rem; color: var(--text-muted-color); margin-bottom: 15px;}
        .modal .back-to-login-link { font-size: 0.85rem; color: var(--primary-color) !important;}


        /* DESKTOP VIEW */
        @media (min-width: 992px) {
            .login-card {
                flex-direction: row; 
                max-width: 1000px; 
                background: rgba(255, 255, 255, 0.95); 
                box-shadow: 0 10px 30px -5px rgba(0, 140, 255, 0.15); 
                border: 1px solid rgba(0, 140, 255, 0.1); 
                backdrop-filter: blur(5px); 
            }
            .login-card::before { 
                content: ""; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
                background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.05"><text x="10" y="20" font-family="Arial" font-size="10">FOOD SAFETY</text><text x="70" y="40" font-family="Arial" font-size="10">HACCP</text><text x="30" y="70" font-family="Arial" font-size="10">GMP</text><text x="80" y="90" font-family="Arial" font-size="10">ISO 22000</text></svg>');
                opacity: 0.1; z-index: -1;
            }
            
            .login-hero {
                flex: 0 0 45%;
                max-width: 45%;
                padding: 40px; 
                background: linear-gradient(135deg, var(--hero-dark-color), var(--primary-color)); 
                display: flex; 
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .login-hero::before, .login-hero::after { 
                display: block; 
                content: ''; position: absolute;
                border-radius: 50%;
            }
            .login-hero::before {
                top: -50px; right: -50px; width: 150px; height: 150px;
                background-color: rgba(255, 199, 44, 0.15);
            }
            .login-hero::after {
                bottom: -30px; left: -30px; width: 100px; height: 100px;
                background-color: rgba(0, 166, 81, 0.15);
            }

            .logo-container { 
                background: white; padding: 5px; border-radius: 12px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); margin-bottom: 25px;
                z-index: 2; display: flex; align-items: center; justify-content: center;
                border: 1px solid rgba(0, 0, 0, 0.05);
            }
            .login-logo { 
                width: 150px;
            }
            .hero-title { 
                font-size: 1.8rem; font-weight: 700; margin-bottom: 15px; z-index: 2;
            }
            .hero-text, .features-list { 
                display: block; 
                z-index: 2;
            }
            .hero-text {
                font-size: 1rem; opacity: 0.9; margin-bottom: 20px; max-width: 350px;
            }
            .features-list {
                text-align: left; width: 100%; max-width: 300px;
            }
            .feature-item { display: flex; align-items: center; margin-bottom: 15px; }
            .feature-icon { margin-right: 10px; color: var(--accent-color); }

            .login-form {
                flex: 1; 
                padding: 40px; 
            }
            .form-title { 
                color: var(--hero-dark-color); margin-bottom: 10px; font-weight: 700; font-size: 1.8rem;
                text-align: left; 
            }
            .form-title::after { 
                content: ''; position: absolute; bottom: -5px; left: 0; transform: none; 
                width: 50px; height: 3px;
                background: linear-gradient(90deg, var(--primary-color), var(--secondary-color)); border-radius: 3px;
                opacity: 1; 
            }
            .form-subtitle { 
                color: #666; margin-bottom: 30px; font-weight: 400; font-size: 1rem; text-align: left;
            }

            .form-label { font-size: 1rem; } 
            .form-control { padding: 12px 15px; padding-left: 40px; font-size: 1rem; }
            .input-icon { left: 15px; top: 42px; font-size: 1rem; } 
            .password-toggle { right: 15px; top: 42px; font-size: 1rem; }
            
            .mpin-input-container { gap: 10px; } 
            .mpin-input { max-width: 50px; height: 50px; font-size: 1.5rem; }

            .login-tab { padding: 10px 20px; font-size: 1rem; flex-grow: 0;} 

            .btn-login { padding: 12px; font-size: 1rem; }
            .btn-login::before { 
                content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: 0.5s;
            }
            .btn-login:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 140, 255, 0.3); }
            .btn-login:hover::before { left: 100%; }

            .forgot-password { margin-top: -15px; margin-bottom: 20px; } 
            .forgot-password a { font-size: 0.9rem; }

            .modal-content { max-width: 500px; padding: 30px; }
            .modal-title { font-size: 1.5rem; }
            .modal-logo { width: 80px; margin-bottom: 15px; }
        }
    </style>
</head>

<body>
    <!-- HTML is from your ORIGINAL submission -->
    <div class="login-container animate__animated animate__fadeIn">
        <div class="login-card animate-pop">
            <div class="login-hero">
                <div class="logo-container">
                    <img src="https://efsm.safefoodmitra.com/admin/public/Save Food Mitra logo.jpg" 
                         alt="Company Logo" 
                         class="login-logo">
                </div>
                <h1 class="hero-title">HACCP Pro Admin</h1>
                <p class="hero-text">Manage your food safety compliance with our comprehensive dashboard</p>
                
                <div class="features-list">
                    <div class="feature-item"><i class="fas fa-shield-alt feature-icon"></i><span>Secure access</span></div>
                    <div class="feature-item"><i class="fas fa-chart-line feature-icon"></i><span>Real-time monitoring</span></div>
                    <div class="feature-item"><i class="fas fa-clipboard-check feature-icon"></i><span>Compliance tracking</span></div>
                </div>
            </div>
            
            <div class="login-form"> 
                <h2 class="form-title">Welcome Back</h2> 
                <p class="form-subtitle">Login to access your dashboard</p>
                
                <div class="login-method-tabs">
                    <div class="login-tab active" data-tab="email">Email Login</div>
                    <div class="login-tab" data-tab="mpin">MPIN Login</div>
                </div>
                
                 <form method="POST" action="{{ route('login') }}" id="emailLoginForm" class="login-method-content active">
            @csrf
                    <div class="form-group input-focus-effect">
                        <label for="email" class="form-label">Email Address</label>
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required autofocus>
                    </div>
                    <div class="form-group input-focus-effect">
                        <label for="password" class="form-label">Password</label>
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                        <span class="password-toggle" id="togglePassword"><i class="far fa-eye"></i></span>
                    </div>
                    <div class="forgot-password">
                        <a href="#" id="forgotPasswordLink">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn-login" id="loginButton">
                        <span>Sign In</span><i class="fas fa-sign-in-alt"></i><div class="loader" id="loginLoader"></div>
                    </button>
                </form>
                
                <form method="POST"  id="mpinLoginForm" class="login-method-content">
                    <input type="hidden" name="_token" value="HpouMxjyat6SJy43Mos8vGgzN6Trt7AfsUp1vQpg">
                    <div class="form-group input-focus-effect">
                        <label for="mpin-username" class="form-label">Username</label>
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="username" id="mpin-username" class="form-control" placeholder="Enter your username" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Enter MPIN</label>
                        <div class="mpin-input-container">
                            <input type="password" name="mpin1" class="mpin-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                            <input type="password" name="mpin2" class="mpin-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                            <input type="password" name="mpin3" class="mpin-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                            <input type="password" name="mpin4" class="mpin-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                            <input type="password" name="mpin5" class="mpin-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                            <input type="password" name="mpin6" class="mpin-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        </div>
                    </div>
                    <div class="forgot-password" style="margin-top: 10px; margin-bottom: 20px;"> 
                        <a href="#" id="forgotMpinLink">Forgot MPIN?</a>
                    </div>
                    <button type="submit" class="btn-login" id="mpinLoginButton">
                        <span>Sign In with MPIN</span><i class="fas fa-fingerprint"></i><div class="loader" id="mpinLoginLoader"></div>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal" id="forgotPasswordModal">
        <div class="modal-content">
            <span class="close-modal" data-modal-id="forgotPasswordModal">×</span>
            <div style="text-align: center;">
                <img src="https://efsm.safefoodmitra.com/admin/public/Save Food Mitra logo.jpg" alt="Company Logo" class="modal-logo">
                <h2 class="modal-title">Reset Your Password</h2>
            </div>
            
            
            
            
            
            
            <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                            <div class="card-body">
                                
                                        <x-jet-validation-errors class="" />

           
            <div class="block">



                <label class="form-label">{{ __('Email') }}</label>



                <x-jet-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
            </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <div class="d-grid">
                                            <p>
                    We'll send you a link to reset your password. Please check your inbox and spam folder.
                </p>
             <button type="submit" class="btn-login" style="width: 100%;"><i class="bx bxs-lock-open"></i>Sign in</button>
                                        </div>
                                    </div>
                                   <!--  <p class="mt-4 text-center">Don't have an account yet? <a href="{{route('register')}}">Sign up here</a> </p> -->
                                </div>
                            </div>
                        </form>
            <div style="text-align: center; margin-top: 20px;">
                <p>
                    Remember your password? <a href="#" class="back-to-login-link" data-modal-id="forgotPasswordModal">Back to login</a>
                </p>
            </div>
        </div>
    </div>

    <div class="modal" id="forgotMpinModal">
        <div class="modal-content">
            <span class="close-modal" data-modal-id="forgotMpinModal">×</span>
            <div style="text-align: center;">
                <img src="https://efsm.safefoodmitra.com/admin/public/Save Food Mitra logo.jpg" alt="Company Logo" class="modal-logo">
                <h2 class="modal-title">Reset Your MPIN</h2>
            </div>
            <form id="forgotMpinForm">
                <div class="form-group input-focus-effect">
                    <label for="reset-mpin-username" class="form-label">Username</label>
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" id="reset-mpin-username" name="username" class="form-control" placeholder="Enter your username" required>
                </div>
                 <div class="form-group input-focus-effect">
                    <label for="reset-mpin-email" class="form-label">Registered Email Address</label>
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" id="reset-mpin-email" name="email" class="form-control" placeholder="Enter your registered email" required>
                </div>
                <p>
                    We'll send instructions to reset your MPIN to your registered email address if your username matches.
                </p>
                <button type="submit" class="btn-login" style="width: 100%;">
                    <span>Send MPIN Reset Instructions</span><i class="fas fa-paper-plane"></i>
                </button>
            </form>
            <div style="text-align: center; margin-top: 20px;">
                <p>
                    Remember your MPIN? <a href="#" class="back-to-login-link" data-modal-id="forgotMpinModal">Back to login</a>
                </p>
            </div>
        </div>
    </div>
    
    <script>
        // JS remains the same
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const passwordInput = document.querySelector('#password');
            const eyeIcon = togglePassword ? togglePassword.querySelector('i') : null;

            const emailLoginForm = document.getElementById('emailLoginForm');
            const emailLoginButton = document.getElementById('loginButton');
            const emailLoginLoader = document.getElementById('loginLoader');
            const emailLoginText = emailLoginButton ? emailLoginButton.querySelector('span') : null;
            const emailLoginIcon = emailLoginButton ? emailLoginButton.querySelector('.fa-sign-in-alt') : null;

            const mpinLoginForm = document.getElementById('mpinLoginForm');
            const mpinLoginButton = document.getElementById('mpinLoginButton');
            const mpinLoginLoader = document.getElementById('mpinLoginLoader');
            const mpinLoginText = mpinLoginButton ? mpinLoginButton.querySelector('span') : null;
            const mpinLoginIcon = mpinLoginButton ? mpinLoginButton.querySelector('.fa-fingerprint') : null;
            
            const mpinInputs = document.querySelectorAll('.mpin-input');
            const loginTabs = document.querySelectorAll('.login-tab');
            const loginContents = document.querySelectorAll('.login-method-content');

            if (togglePassword && passwordInput && eyeIcon) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    eyeIcon.classList.toggle('fa-eye');
                    eyeIcon.classList.toggle('fa-eye-slash');
                });
            }

            function setupFormLoader(form, button, loader, textElement, iconElement, loadingText) {
                if (form && button && loader && textElement) {
                    form.addEventListener('submit', function(e) {
                        if (!form.checkValidity()) {
                            return; 
                        }
                        textElement.textContent = loadingText;
                        if (iconElement) iconElement.style.display = 'none';
                        loader.style.display = 'inline-block'; 
                        button.disabled = true;
                    });
                }
            }
            setupFormLoader(emailLoginForm, emailLoginButton, emailLoginLoader, emailLoginText, emailLoginIcon, 'Authenticating...');
            setupFormLoader(mpinLoginForm, mpinLoginButton, mpinLoginLoader, mpinLoginText, mpinLoginIcon, 'Verifying MPIN...');

            mpinInputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    if (this.value.length === 1 && /^[0-9]$/.test(this.value) && index < mpinInputs.length - 1) {
                        mpinInputs[index + 1].focus();
                    }
                });
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value.length === 0 && index > 0) {
                        mpinInputs[index - 1].focus();
                    }
                    if (!/^[0-9]$/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Tab' && !e.key.includes('Arrow')) {
                         if (!(e.ctrlKey || e.metaKey)) { 
                            e.preventDefault();
                         }
                    }
                });
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pasteData = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
                    if (!pasteData) return;
                    
                    let currentInputIndex = index;
                    for (let i = 0; i < pasteData.length && currentInputIndex < mpinInputs.length; i++) {
                        mpinInputs[currentInputIndex].value = pasteData[i];
                        if (currentInputIndex < mpinInputs.length - 1) {
                           if(pasteData.length > 1) mpinInputs[currentInputIndex + 1].focus();
                        }
                        currentInputIndex++;
                    }
                    if (currentInputIndex < mpinInputs.length) {
                         mpinInputs[currentInputIndex].focus();
                    } else {
                        mpinInputs[mpinInputs.length - 1].focus();
                    }
                });
            });

            loginTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabId = this.dataset.tab;
                    loginTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    loginContents.forEach(c => c.classList.remove('active'));
                    const activeContent = document.getElementById(`${tabId}LoginForm`);
                    if (activeContent) {
                        activeContent.classList.add('active');
                        const firstInput = activeContent.querySelector('input:not([type="hidden"])');
                        if(firstInput) firstInput.focus();
                    }
                });
            });

            const allModals = document.querySelectorAll('.modal');
            const openModalLinks = document.querySelectorAll('#forgotPasswordLink, #forgotMpinLink');
            const closeModalButtons = document.querySelectorAll('.close-modal');
            const backToLoginLinks = document.querySelectorAll('.back-to-login-link');

            function openModal(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = 'flex';
                    const firstInput = modal.querySelector('input:not([type="hidden"])');
                    if(firstInput) firstInput.focus();
                }
            }
            function closeModal(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) modal.style.display = 'none';
            }

            openModalLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const modalId = (this.id === 'forgotPasswordLink') ? 'forgotPasswordModal' : 'forgotMpinLink';
                    openModal(modalId);
                });
            });

            closeModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    closeModal(this.dataset.modalId);
                });
            });
            
            backToLoginLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    closeModal(this.dataset.modalId);
                });
            });

            window.addEventListener('click', function(e) {
                allModals.forEach(modal => {
                    if (e.target === modal) {
                        modal.style.display = 'none';
                    }
                });
            });
             window.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    allModals.forEach(modal => {
                        if (modal.style.display === 'flex') {
                            closeModal(modal.id);
                        }
                    });
                }
            });
            
            const initialFocusInputEmail = document.querySelector('#emailLoginForm input[name="email"]');
            const initialFocusInputMpin = document.querySelector('#mpinLoginForm input[name="username"]');

            if (document.getElementById('emailLoginForm').classList.contains('active') && initialFocusInputEmail) {
                initialFocusInputEmail.focus();
            } else if (document.getElementById('mpinLoginForm').classList.contains('active') && initialFocusInputMpin) {
                 initialFocusInputMpin.focus();
            }

            const loginCard = document.querySelector('.login-card');
            if (loginCard) { 
                const applyDesktopHover = () => {
                     if (window.innerWidth >= 992) {
                        loginCard.style.boxShadow = '0 15px 35px -5px rgba(0, 140, 255, 0.2)';
                        loginCard.style.transform = 'translateY(-5px)';
                     }
                };
                const removeDesktopHover = () => {
                    if (window.innerWidth >= 992) {
                        loginCard.style.boxShadow = '0 10px 30px -5px rgba(0, 140, 255, 0.15)';
                         loginCard.style.transform = '';
                    } else { 
                        loginCard.style.boxShadow = 'var(--card-shadow)'; 
                        loginCard.style.transform = '';
                    }
                };

                loginCard.addEventListener('mouseenter', applyDesktopHover);
                loginCard.addEventListener('mouseleave', removeDesktopHover);
                
                window.addEventListener('resize', () => {
                    const isHovering = loginCard.matches(':hover');
                    if(!isHovering) {
                        removeDesktopHover(); 
                    }
                });
            }
        });
    </script>
</body>
</html>