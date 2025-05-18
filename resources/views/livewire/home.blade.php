<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

new class extends Component {
    //buat tombol-tombol di tampilan home
    public function logout(): void
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        $this->redirectRoute('login');
    }
}; ?>

<div>
     <x-header title="Selamat Datang di Laman Utama" separator />

    <x-button label="Keluar" wire:click="logout" spinner="logout" class="btn-primary" />
</div>
