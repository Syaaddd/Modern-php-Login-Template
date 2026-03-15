<?php
require_once 'includes/session.php';
require_once 'includes/functions.php';

$pageTitle = 'Sign Up - Register';

// Redirect to dashboard if already logged in
if (isLoggedIn()) {
    redirect('dashboard.php');
}

$flash = getFlashMessage();
?>
<?php include 'includes/header.php'; ?>

<!-- Main Container -->
<div class="min-h-screen gradient-bg flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Animated Background Shapes -->
    <div class="shape w-80 h-80 bg-primary-400 top-10 left-10 animate-pulse-glow" style="animation-delay: 0s;"></div>
    <div class="shape w-96 h-96 bg-accent-400 bottom-10 right-10 animate-pulse-glow" style="animation-delay: 2s;"></div>
    <div class="shape w-72 h-72 bg-primary-300 top-1/2 left-1/4 animate-bounce-subtle" style="animation-delay: 4s;"></div>

    <!-- Register Card -->
    <div class="glass rounded-3xl shadow-2xl card-shadow p-8 w-full max-w-md animate-slide-up relative z-10 border border-white/20">

        <!-- Logo/Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-accent-500 to-accent-700 rounded-2xl shadow-lg mb-4 icon-bounce">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">Create Account</h2>
            <p class="text-gray-500 mt-2">Sign up to get started</p>
        </div>

        <!-- Flash Messages -->
        <?php if ($flash): ?>
            <div class="flash-message mb-6 p-4 rounded-xl flex items-center gap-3 animate-fade-in <?php 
                echo $flash['type'] === 'error' 
                    ? 'bg-red-50 border border-red-200 text-red-700' 
                    : 'bg-emerald-50 border border-emerald-200 text-emerald-700'; 
            ?>">
                <?php if ($flash['type'] === 'error'): ?>
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                <?php else: ?>
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                <?php endif; ?>
                <span class="text-sm font-medium"><?php echo sanitize($flash['message']); ?></span>
            </div>
        <?php endif; ?>

        <!-- Register Form -->
        <form class="space-y-5" method="post" action="proses_register.php">
            <!-- Username Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input
                    type="text"
                    name="username"
                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-accent-500 outline-none transition-all input-glow"
                    placeholder="Choose a username"
                    required
                    minlength="3"
                    />
                </div>
            </div>

            <!-- Email Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input
                    type="email"
                    name="email"
                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-accent-500 outline-none transition-all input-glow"
                    placeholder="your@email.com"
                    required
                    />
                </div>
            </div>

            <!-- Password Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input
                    type="password"
                    name="password"
                    id="password"
                    class="w-full pl-12 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-accent-500 outline-none transition-all input-glow"
                    placeholder="Create a password"
                    required
                    minlength="6"
                    />
                    <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-accent-500 transition-colors focus:outline-none toggle-password" data-target="password">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1.5 ml-1">Minimum 6 characters</p>
            </div>

            <!-- Confirm Password Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <input
                    type="password"
                    name="confirm_password"
                    id="confirm_password"
                    class="w-full pl-12 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-accent-500 outline-none transition-all input-glow"
                    placeholder="Confirm your password"
                    required
                    minlength="6"
                    />
                    <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-accent-500 transition-colors focus:outline-none toggle-password" data-target="confirm_password">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button
                class="w-full bg-gradient-to-r from-accent-500 to-accent-600 hover:from-accent-600 hover:to-accent-700 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 ripple"
                type="submit"
                name="register"
            >
                Create Account
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500">or</span>
            </div>
        </div>

        <!-- Sign In Link -->
        <div class="text-center">
            <p class="text-gray-600">
                Already have an account?
                <a href="index.php" class="text-accent-600 hover:text-accent-700 font-semibold transition-colors">Sign in</a>
            </p>
        </div>
    </div>

    <!-- Footer Text -->
    <p class="absolute bottom-4 text-white/70 text-sm font-medium">© 2024 Login System. All rights reserved.</p>
</div>

<?php include 'includes/footer.php'; ?>
