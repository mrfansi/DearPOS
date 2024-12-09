<?php

use App\Livewire\Actions\Logout;

$logout = function (Logout $logout) {
    $logout();

    $this->redirect('/', navigate: true);
};

?>

<div class="drawer">
  <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
  <div class="flex flex-col drawer-content">
    <!-- Navbar -->
    <div class="navbar bg-base-100">
      <div class="flex-none lg:hidden">
        <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-square btn-ghost">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            class="inline-block w-6 h-6 stroke-current">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </label>
      </div>
      <div class="flex-1 px-2 mx-2">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" wire:navigate class="text-xl btn btn-ghost">
          {{ config('app.name') }}
        </a>
      </div>
      <div class="hidden flex-none lg:block">
        <ul class="menu menu-horizontal">
          <!-- Navigation Links -->
          <li><a href="{{ route('dashboard') }}" wire:navigate
              class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>

          <!-- Settings Dropdown -->
          <li>
            <details>
              <summary>
                {{ Auth::user()->name }}
              </summary>
              <ul class="p-2 rounded-t-none bg-base-100">
                <li>
                  <a href="{{ route('profile') }}" wire:navigate>Profile</a>
                </li>
                <li>
                  <!-- Authentication -->
                  <button wire:click="logout" class="w-full text-start">
                    Log Out
                  </button>
                </li>
              </ul>
            </details>
          </li>
        </ul>
      </div>
    </div>

    <!-- Page Content -->
    <main>
      {{ $slot }}
    </main>
  </div>

  <!-- Mobile Drawer -->
  <div class="drawer-side">
    <label for="my-drawer-3" aria-label="close sidebar" class="drawer-overlay"></label>
    <ul class="p-4 w-80 min-h-full menu bg-base-200">
      <li><a href="{{ route('dashboard') }}" wire:navigate
          class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
      <div class="divider"></div>
      <li><a href="{{ route('profile') }}" wire:navigate>Profile</a></li>
      <li>
        <button wire:click="logout" class="w-full text-start">
          Log Out
        </button>
      </li>
    </ul>
  </div>
</div>
