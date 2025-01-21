<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        if (Auth::guard('student')->check()) {
            $this->redirectIntended(default: route('students.dashboard', absolute: false), navigate: true);
        } elseif (Auth::guard('web')->check()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        }

        // $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">

    <x-auth-session-status class="rounded dark:bg-gray-600 bg-gray-200 p-3 text-center text-gray-900 dark:text-white"
        :status="session('status')" />

    <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white">
        Sign in to platform
    </h2>
    <form class="mt-8 space-y-6" wire:submit="login" novalidate>
        {{-- user type --}}
        <div>
            <select wire:model.live="form.user_type" id="user_type" required
                class="bg-white border border-white dark:border-gray-800 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
                <option value="student" selected>Student Portal Login</option>
                <option value="web">Coordinator Portal Login</option>
            </select>
            <x-input-error :messages="$errors->get('form.user_type')" class="mt-2" />
        </div>

        <div>
            @if ($form->user_type !== 'student')
                <x-input-label for="email" :value="__('Email')" />

                <x-text-input wire:model="form.email" id="email" type="email" name="email" autofocus
                    autocomplete="username" placeholder="name@company.com" />
            @else
                <x-input-label for="regno" :value="__('Reg/Matric Number')" />
                <x-text-input wire:model="form.regno" id="regno" type="text" name="regno" autofocus
                    autocomplete="username" placeholder="valid reg/Mat No." />
            @endif

            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full" type="password"
                name="password" placeholder="••••••••" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input wire:model="form.remember" id="remember" aria-describedby="remember" name="remember"
                    type="checkbox"
                    class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
            </div>
            <div class="ml-3 text-sm">
                <label for="remember" class="font-medium text-gray-900 dark:text-white">{{ __('Remember me') }}</label>
            </div>
            <a href="{{ route('password.request') }}"
                class="ml-auto text-sm text-blue-700 hover:underline dark:text-blue-500" wire:navigate>
                {{ __('Forgot your password?') }}</a>
        </div>

        <x-primary-button class="w-full">
            {{ __('Log in') }}
        </x-primary-button>

        @if (Route::has('register'))
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Don't have an account? <a href="{{ route('register') }}" wire:navigate
                    class="text-blue-700 hover:underline dark:text-blue-400">Create
                    Account</a>
            </div>
        @endif

    </form>
</div>
