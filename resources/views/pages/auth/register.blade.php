<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\Role;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // event(new Registered(($user = User::create($validated))));
        // Create user
        $user = User::create($validated);

        // Assign default role
        $defaultRole = Role::where('name', 'User')->first(); // Ensure 'User' role exists

        if ($defaultRole) {
            $user->roles()->attach($defaultRole->role_id);
        }

        // Fire registered event
        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full max-w-xl p-6 space-y-8d sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">

    <x-auth-session-status class="rounded dark:bg-gray-600 bg-gray-200 p-3 text-center text-gray-900 dark:text-white"
        :status="session('status')" />

    <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white">
        Sign up to Continue!
    </h2>
    <form class="mt-8 space-y-6" wire:submit="register" novalidate>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />

            <x-text-input wire:model="name" id="name" type="text" name="name" autofocus autocomplete="name"
                placeholder="Enter Full name" required />

            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>


        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone')" />

            <x-text-input wire:model="phone" id="phone" type="text" name="phone" autofocus autocomplete="phone"
                placeholder="Enter your contact no." max="13" required />

            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- mail -->
        <div>
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input wire:model="email" id="email" type="email" name="email" autofocus
                autocomplete="username" placeholder="E.g name@mail.com" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password"
                placeholder="••••••••" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" placeholder="••••••••" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full">
            {{ __('Register') }}
        </x-primary-button>

        @if (Route::has('login'))
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                {{ __('Already registered?') }} <a href="{{ route('login') }}" wire:navigate
                    class="text-blue-700 hover:underline dark:text-blue-400">Log in
                    Account</a>
            </div>
        @endif

    </form>
</div>
