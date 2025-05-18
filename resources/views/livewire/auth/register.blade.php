<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('home', absolute: false), navigate: true);
    }
}; ?>
<div>
    <div class="px-10 lg:px-0 flex items-center justify-center min-h-dvh bg-gray-100 dark:bg-none dark:bg-neutral-900">
        <div class="w-md shadow">
            <div class="bg-white dark:bg-neutral-800 p-8 space-y-6">

                <x-form wire:submit="register">
                    <x-input label="Nama" wire:model="name" icon="o-envelope" placeholder="nama lengkap atau panggilan" wire:loading.attr="disabled" wire:target="register" />
                    <x-input label="Alamat E-mail" wire:model="email" icon="o-envelope" placeholder="email@contoh.com" wire:loading.attr="disabled" wire:target="register" />
                    <x-input label="Kata Sandi" wire:model="password" type="password" icon="o-key" placeholder="contoh: katasandi1234" wire:loading.attr="disabled" wire:target="register" />
                    <x-input label="Konfirmasi Kata Sandi" wire:model="password_confirmation" type="password" icon="o-key" placeholder="ulangi tulis kata sandi yang tadi" wire:loading.attr="disabled" wire:target="register" />

                    <div class="space-y-4 mt-4">
                        <x-button label="Daftarkan Akun" type="submit" class="btn-primary w-full" spinner="register" />

                        <div class="space-x-1 text-center text-sm">
                            <span class="text-zinc-600 dark:text-zinc-400">{{ __('Atau sudah punya akun?') }}</span>
                            <a href="{{ route('login') }}" wire:navigate class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Masuk') }}</a>
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</div>