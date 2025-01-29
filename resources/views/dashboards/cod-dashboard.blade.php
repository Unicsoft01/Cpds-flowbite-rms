{{-- <div>
    <x-primary-button>Lorem, ipsum dolor.</x-primary-button>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md dark:shadow-sm  sm:rounded-lg">
                <div class="p-6 text-gray-900  dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

</div> --}}
<div x-data="{ showSplash: @entangle('showSplash') }">
    <!-- Splash Screen -->
    <div id="splash-screen" x-show="showSplash"
        class="fixed inset-0 flex items-center justify-center bg-gray-900 text-white z-50">
        <div class="text-center">
            <img src="/images/logo.png" alt="Logo" class="w-24 h-24 mx-auto">
            <p class="mt-4 font-bold" x-text="$wire.loadingMessage"></p>
            <div class="loader mt-4"></div>
        </div>
    </div>

    <!-- Admin Panel Content -->
    <div x-show="!showSplash" x-transition.opacity.duration.500ms>
        <h1 class="text-2xl font-bold text-gray-800">Welcome to the Admin Panel!</h1>
        <!-- Add your admin panel content here -->
    </div>

    <style>
        .loader {
            border: 4px solid transparent;
            border-top: 4px solid #fff;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</div>
