<?php
require_once 'config/database.php';
require_once 'includes/session.php';
require_once 'includes/functions.php';

$pageTitle = 'Dashboard';

// Require user to be logged in
requireLogin();

$flash = getFlashMessage();

// Get user data from database
$user_id = getCurrentUserId();
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Get user initials for avatar
$initials = strtoupper(substr($user['username'], 0, 2));
?>
<?php include 'includes/header.php'; ?>

<!-- Main Container -->
<div class="min-h-screen gradient-bg flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Animated Background Shapes -->
    <div class="shape w-80 h-80 bg-primary-400 top-10 left-10 animate-pulse-glow" style="animation-delay: 0s;"></div>
    <div class="shape w-96 h-96 bg-accent-400 bottom-10 right-10 animate-pulse-glow" style="animation-delay: 2s;"></div>
    <div class="shape w-72 h-72 bg-primary-300 top-1/2 left-1/4 animate-bounce-subtle" style="animation-delay: 4s;"></div>

    <!-- Dashboard Card -->
    <div class="glass rounded-3xl shadow-2xl card-shadow p-8 w-full max-w-lg animate-slide-up relative z-10 border border-white/20">

        <!-- Header with Avatar -->
        <div class="text-center mb-8">
            <!-- User Avatar -->
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full shadow-xl mb-4 ring-4 ring-white/50 icon-bounce">
                <span class="text-3xl font-bold text-white"><?php echo $initials; ?></span>
            </div>

            <h2 class="text-3xl font-bold text-gray-800">Welcome Back!</h2>
            <p class="text-gray-500 mt-1"><?php echo sanitize(getCurrentUsername()); ?></p>
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

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <!-- Account Status Card -->
            <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl p-4 border border-primary-200">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-primary-700">Status</span>
                </div>
                <p class="text-lg font-bold text-primary-900">Active</p>
            </div>
            
            <!-- Member Since Card -->
            <div class="bg-gradient-to-br from-accent-50 to-accent-100 rounded-2xl p-4 border border-accent-200">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-accent-500 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-accent-700">Joined</span>
                </div>
                <p class="text-lg font-bold text-accent-900"><?php echo date('M Y', strtotime($user['created_at'] ?? 'now')); ?></p>
            </div>
        </div>

        <!-- User Info Section -->
        <div class="bg-gray-50 rounded-2xl p-5 mb-6 border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Account Information
            </h3>
            
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-gray-500">Username</p>
                        <p class="text-sm font-medium text-gray-900 truncate"><?php echo sanitize(getCurrentUsername()); ?></p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-gray-500">Email</p>
                        <p class="text-sm font-medium text-gray-900 truncate"><?php echo sanitize($user['email'] ?? 'N/A'); ?></p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-gray-500">Last Activity</p>
                        <p class="text-sm font-medium text-gray-900">Just now</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="logout.php" class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 ripple">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </a>
            
            <a href="index.php" class="flex items-center justify-center gap-2 w-full bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3.5 rounded-xl transition-all duration-300 border-2 border-gray-200 hover:border-gray-300 ripple">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Login
            </a>
        </div>
    </div>

    <!-- Footer Text -->
    <p class="absolute bottom-4 text-white/70 text-sm font-medium">© 2024 Login System. All rights reserved.</p>
</div>

<?php 
include 'includes/footer.php';
$stmt->close();
$conn->close();
?>
