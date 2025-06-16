<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ElysianHome -  Welcome Back</title>
    <link rel="icon" type="image/png" href="{{ asset('fe/assets/img/logo.png') }}">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert CSS and JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .glass-effect {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        .floating-animation-delay {
            animation: float 6s ease-in-out infinite;
            animation-delay: -3s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .gradient-text {
            background: linear-gradient(135deg, #ffffff 0%, #7500fa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
            border-color: #667eea;
            transform: translateY(-2px);
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body id="body" class="min-h-screen bg-gradient-to-br from-purple-800 via-blue-700 to-red-500 animate-gradient overflow-hidden">
    <!-- Floating Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-10 left-10 w-72 h-72 bg-white opacity-10 rounded-full blur-xl floating-animation"></div>
        <div class="absolute top-1/2 right-10 w-96 h-96 bg-blue-300 opacity-10 rounded-full blur-xl floating-animation-delay"></div>
        <div class="absolute bottom-10 left-1/3 w-80 h-80 bg-yellow-300 opacity-10 rounded-full blur-xl floating-animation"></div>
    </div>

    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Main Card -->
            <div class="glass-effect rounded-3xl shadow-2xl p-8 transform hover:scale-105 transition-all duration-300">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-4 shadow-lg">
                        <i class="fas fa-user-shield text-white text-2xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold gradient-text mb-2">Welcome Back!</h1>
                    <p class="text-white/80 font-medium">Login Untuk Berbelanja di Elysian Home!</p>
                </div>

                <!-- Login Form -->
                <form method="POST" id="formLogin" action="/login" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-white/60 group-focus-within:text-blue-400 transition-colors duration-200"></i>
                        </div>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            required
                            placeholder="Enter your email"
                            class="w-full pl-12 pr-4 py-4 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 input-focus transition-all duration-300 focus:outline-none"
                        >
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-500/20 to-purple-500/20 opacity-0 group-focus-within:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    </div>

                    <!-- Password Field -->
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-white/60 group-focus-within:text-blue-400 transition-colors duration-200"></i>
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            placeholder="Enter your password"
                            class="w-full pl-12 pr-12 py-4 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 input-focus transition-all duration-300 focus:outline-none"
                        >
                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-white/60 hover:text-white transition-colors duration-200"
                        >
                            <i id="passwordToggle" class="fas fa-eye"></i>
                        </button>
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-500/20 to-purple-500/20 opacity-0 group-focus-within:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center space-x-2 cursor-pointer group">
                            <input type="checkbox" name="remember" class="sr-only">
                            <div class="w-5 h-5 bg-white/10 border border-white/30 rounded flex items-center justify-center group-hover:bg-white/20 transition-colors duration-200">
                                <i class="fas fa-check text-white text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
                            </div>
                            <span class="text-white/80 text-sm font-medium">Remember me</span>
                        </label>
                    </div>

                    <!-- Login Button -->
                    <button
                        type="button" id="btnLogin"
                        class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg btn-hover transition-all duration-300 transform"
                    >
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign In
                    </button>
                </form>

                <!-- Register Link -->
                <div class="text-center mt-6">
                    <p class="text-white/80">
                        Belum Punya Akun?
                        <a href="/register" class="text-blue-300 hover:text-blue-200 font-semibold transition-colors duration-200 hover:underline">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 text-white/60">
                <p class="text-sm">© 2025 ElysianHome. Made with ❤️</p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggle');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        function tampil_pesan() {
            // Check if session variables are set
            const success = @json(session('success'));
            const error = @json(session('error'));

            // Check if swal is defined
            if (typeof swal === 'undefined') {
                console.error('SweetAlert is not loaded. Check CDN or network.');
                return;
            }

            // Show alerts only if session variables exist
            if (success) {
                Swal.fire({
                    title: 'Good Job!',
                    text: success,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            }
            if (error) {
                Swal.fire({
                    title: 'Error!',
                    text: error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }

        // Use DOMContentLoaded for better timing
        document.addEventListener('DOMContentLoaded', function() {
            tampil_pesan();

            // Add loading animation to form
            const form = document.querySelector('form');
            const submitBtn = form.querySelector('button[type="submit"]');

            form.addEventListener('submit', function() {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Signing In...';
                submitBtn.disabled = true;
            });
        });

        // Add floating particle effect
        function createParticle() {
            const particle = document.createElement('div');
            particle.className = 'absolute w-2 h-2 bg-white/20 rounded-full pointer-events-none';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = '100%';
            particle.style.animation = `float-up ${3 + Math.random() * 4}s linear forwards`;

            document.body.appendChild(particle);

            setTimeout(() => {
                particle.remove();
            }, 7000);
        }

        // Add CSS for particle animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes float-up {
                0% {
                    transform: translateY(0) scale(0);
                    opacity: 1;
                }
                50% {
                    transform: translateY(-50vh) scale(1);
                    opacity: 0.7;
                }
                100% {
                    transform: translateY(-100vh) scale(0);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Create particles periodically
        setInterval(createParticle, 2000);

        const btnSave = document.getElementById('btnLogin');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const form = document.getElementById('formLogin');
        const body = document.getElementById('body');

        function simpan() {
            if (email.value === '') {
                email.focus();
                Swal.fire({
                        icon: 'error',
                        title: 'Data Kosong!',
                        text: 'Input Email Harus Di Isi!',
                    });
            } else if (password.value === '') {
                password.focus();
                Swal.fire({
                        icon: 'error',
                        title: 'Data Kosong!',
                        text: 'Input Password Harus Di Isi!',
                    });
            } else {
                form.submit();
            }
        }

        btnSave.onclick = function() {
            simpan();
        }
    </script>
</body>
</html>
