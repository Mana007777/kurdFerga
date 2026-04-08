<?php

use App\Concerns\PasswordValidationRules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Security settings')] class extends Component {
    use PasswordValidationRules;

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public bool $canManageTwoFactor;

    public bool $twoFactorEnabled;

    public bool $requiresConfirmation;

    /**
     * Mount the component.
     */
    public function mount(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        $this->canManageTwoFactor = Features::canManageTwoFactorAuthentication();

        if ($this->canManageTwoFactor) {
            if (Fortify::confirmsTwoFactorAuthentication() && is_null(auth()->user()->two_factor_confirmed_at)) {
                $disableTwoFactorAuthentication(auth()->user());
            }

            $this->twoFactorEnabled = auth()->user()->hasEnabledTwoFactorAuthentication();
            $this->requiresConfirmation = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm');
        }
    }

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => $this->currentPasswordRules(),
                'password' => $this->passwordRules(),
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }

    /**
     * Handle the two-factor authentication enabled event.
     */
    #[On('two-factor-enabled')]
    public function onTwoFactorEnabled(): void
    {
        $this->twoFactorEnabled = true;
    }

    /**
     * Disable two-factor authentication for the user.
     */
    public function disable(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        $disableTwoFactorAuthentication(auth()->user());

        $this->twoFactorEnabled = false;
    }
}; ?>

<section class="w-full">
    <flux:heading class="sr-only">{{ __('Security settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Security Protocol')" :subheading="__('Ensure your account is using advanced encryption and 2FA protocols.')">
        <div class="max-w-2xl space-y-20">
            {{-- Password Update --}}
            <form method="POST" wire:submit="updatePassword" class="space-y-12">
                <div class="space-y-8">
                    <div class="flex items-center gap-3">
                        <flux:icon.key class="w-5 h-5 text-violet-500" />
                        <h2 class="text-sm font-black text-zinc-500 uppercase tracking-widest">Update Data encryption</h2>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div class="space-y-2">
                             <flux:input
                                wire:model="current_password"
                                :label="__('Primary Key')"
                                type="password"
                                required
                                autocomplete="current-password"
                                viewable
                                class="!bg-zinc-950 !border-zinc-800 !text-white !font-black !h-14 !px-6 !rounded-xl focus:!border-violet-500 transition-all"
                            />
                            <p class="text-[8px] font-mono text-zinc-600 uppercase tracking-widest pl-2">Current authorization key.</p>
                        </div>

                        <div class="space-y-2">
                            <flux:input
                                wire:model="password"
                                :label="__('New Encryption sequence')"
                                type="password"
                                required
                                autocomplete="new-password"
                                viewable
                                class="!bg-zinc-950 !border-zinc-800 !text-white !font-black !h-14 !px-6 !rounded-xl focus:!border-violet-500 transition-all"
                            />
                            <p class="text-[8px] font-mono text-zinc-600 uppercase tracking-widest pl-2">Recommended: 16+ characters // High complexity.</p>
                        </div>

                        <div class="space-y-2">
                            <flux:input
                                wire:model="password_confirmation"
                                :label="__('Confirm Sequence')"
                                type="password"
                                required
                                autocomplete="new-password"
                                viewable
                                class="!bg-zinc-950 !border-zinc-800 !text-white !font-black !h-14 !px-6 !rounded-xl focus:!border-violet-500 transition-all"
                            />
                            <p class="text-[8px] font-mono text-zinc-600 uppercase tracking-widest pl-2">Security redundancy check.</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-6 pt-6 border-t border-zinc-900">
                    <flux:button variant="filled" type="submit" class="!px-12 !py-6 !bg-zinc-900 !hover:bg-violet-600 !text-white !font-black !text-[11px] !uppercase !tracking-[0.4em] !rounded-2xl !shadow-xl !transition-all">
                        Sync New Key
                    </flux:button>

                    <x-action-message class="font-mono text-[9px] text-emerald-500 uppercase tracking-widest" on="password-updated">
                        [Key Updated]
                    </x-action-message>
                </div>
            </form>

            {{-- Two-Factor Authentication --}}
            @if ($canManageTwoFactor)
                <div class="pt-20 border-t border-zinc-900 space-y-12">
                     <div class="flex items-center gap-3">
                        <flux:icon.shield-check class="w-5 h-5 text-emerald-500" />
                        <h2 class="text-sm font-black text-zinc-500 uppercase tracking-widest">Multi-Layer Protocol (2FA)</h2>
                    </div>

                    <div class="bg-zinc-900/40 border border-zinc-800 rounded-[2rem] p-8 md:p-12 relative overflow-hidden group">
                         <div class="absolute inset-0 bg-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                         
                         <div class="relative z-10 space-y-8" wire:cloak>
                            @if ($twoFactorEnabled)
                                <div class="space-y-6">
                                    <div class="flex items-center gap-2 px-3 py-1 rounded bg-emerald-500/10 border border-emerald-500/20 w-fit">
                                        <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest animate-pulse">2FA-ACTIVE</span>
                                    </div>
                                    <p class="text-zinc-500 font-mono text-xs uppercase tracking-tight leading-relaxed">
                                        You will be prompted for a secure, random pin during login, which you can retrieve from the TOTP-supported application on your mobile unit.
                                    </p>

                                    <div class="flex justify-start">
                                        <flux:button
                                            variant="ghost"
                                            wire:click="disable"
                                            class="!text-red-500 hover:!bg-red-500/10 !font-black !text-[10px] !uppercase !tracking-widest"
                                        >
                                            Disable 2FA Layer
                                        </flux:button>
                                    </div>

                                    <livewire:pages::settings.two-factor.recovery-codes :$requiresConfirmation />
                                </div>
                            @else
                                <div class="space-y-6">
                                    <div class="flex items-center gap-2 px-3 py-1 rounded bg-zinc-800 border border-zinc-700 w-fit">
                                        <span class="text-[9px] font-black text-zinc-500 uppercase tracking-widest">2FA-OFFLINE</span>
                                    </div>
                                    <p class="text-zinc-500 font-mono text-xs uppercase tracking-tight leading-relaxed">
                                        When you enable multi-layer authentication, you will be prompted for a secure pin during login. This pin can be retrieved from a dedicated TOTP-supported application.
                                    </p>

                                    <flux:modal.trigger name="two-factor-setup-modal">
                                        <flux:button
                                            variant="filled"
                                            wire:click="$dispatch('start-two-factor-setup')"
                                            class="!bg-emerald-600 !hover:bg-emerald-500 !text-white !font-black !text-[10px] !uppercase !tracking-widest !rounded-xl !px-10 !py-4"
                                        >
                                            Initialize 2FA Sequence
                                        </flux:button>
                                    </flux:modal.trigger>

                                    <livewire:pages::settings.two-factor-setup-modal :requires-confirmation="$requiresConfirmation" />
                                </div>
                            @endif
                         </div>

                         <!-- Technical Mark -->
                         <div class="absolute bottom-6 right-8 text-[8px] font-mono text-zinc-800 uppercase tracking-widest">TOTP-LAYER::02</div>
                    </div>
                </div>
            @endif
        </div>
    </x-pages::settings.layout>
</section>
