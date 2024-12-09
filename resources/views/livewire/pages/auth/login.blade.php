<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
};

?>

<div>
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-info mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <div class="min-h-screen flex items-center justify-center">
        <div class="card w-96 bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title justify-center text-2xl font-semibold mb-5">Login</h2>

                <form wire:submit="login">
                    <!-- Email Address -->
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email"
                               wire:model="form.email"
                               class="input input-bordered w-full @error('form.email') input-error @enderror"
                               placeholder="Enter your email"/>
                        @error('form.email')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-control w-full mt-4">
                        <label class="label">
                            <span class="label-text">Password</span>
                        </label>
                        <input type="password"
                               wire:model="form.password"
                               class="input input-bordered w-full @error('form.password') input-error @enderror"
                               placeholder="Enter your password"/>
                        @error('form.password')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-control mt-4">
                        <label class="label cursor-pointer">
                            <span class="label-text">Remember me</span>
                            <input type="checkbox" wire:model="form.remember" class="checkbox checkbox-primary"/>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        @if (Route::has('password.request'))
                            <a class="link link-hover text-sm"
                               href="{{ route('password.request') }}">
                                Forgot your password?
                            </a>
                        @endif

                        <button type="submit" class="btn btn-primary ml-4">
                            Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
