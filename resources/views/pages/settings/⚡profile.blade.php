<?php

use App\Concerns\ProfileValidationRules;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\WithFileUploads;

new #[Title('Profile settings')] class extends Component {
    use ProfileValidationRules, WithFileUploads;

    public string $name = '';
    public string $email = '';
    public $photo;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate(array_merge(
            $this->profileRules($user->id),
            ['photo' => ['nullable', 'image', 'max:1024']]
        ));

        if ($this->photo) {
            $user->profile_photo_path = $this->photo->store('profile-photos', 'public');
        }

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! Auth::user() instanceof MustVerifyEmail
            || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }
}; ?>

<section class="w-full">
    <flux:heading class="sr-only">{{ __('Profile settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Personnel Dossier')" :subheading="__('Update your system credentials and bio-scan data.')">
        <div class="max-w-2xl">
            <form wire:submit="updateProfileInformation" class="space-y-12">
                {{-- Bio-Scan Section --}}
                <div class="flex flex-col md:flex-row items-center gap-10 p-8 rounded-[2rem] bg-zinc-950 border border-zinc-900 relative group overflow-hidden">
                    <div class="absolute inset-0 bg-violet-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="relative">
                        <div class="absolute -inset-4 border border-violet-500/20 rounded-full animate-[spin_10s_linear_infinite]"></div>
                        <div class="absolute -inset-2 border border-violet-500/40 rounded-full animate-[spin_15s_linear_infinite_reverse]"></div>
                        <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-zinc-800 shadow-[0_0_30px_rgba(139,92,246,0.3)] relative z-10">
                            <flux:avatar src="{{ $this->photo ? $this->photo->temporaryUrl() : auth()->user()->profilePhotoUrl() }}" class="!w-full !h-full !rounded-none" />
                        </div>
                    </div>

                    <div class="flex-1 space-y-4">
                        <div>
                            <span class="block text-[8px] font-mono text-zinc-600 uppercase tracking-[0.3em] mb-1">Personnel ID</span>
                            <span class="block text-sm font-mono text-zinc-400 uppercase tracking-widest">USER-{{ str_pad(auth()->id(), 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="space-y-2">
                             <flux:label class="!text-[10px] !font-black !text-zinc-500 !uppercase !tracking-widest">Sync New Bio-Image</flux:label>
                             <flux:input wire:model="photo" type="file" accept="image/*" class="!bg-zinc-950 !border-zinc-800 !text-[10px] !font-mono !text-zinc-400" />
                             <p class="text-[8px] font-mono text-zinc-600 uppercase tracking-widest">Protocol: Max 1024KB // Format: JPG-PNG-WEBP</p>
                        </div>
                    </div>

                    <!-- System Mark -->
                    <div class="absolute top-4 right-4 text-[8px] font-mono text-zinc-800">BIO-AUTH::01</div>
                </div>

                {{-- Data Entry Fields --}}
                <div class="grid grid-cols-1 gap-8">
                    <div class="space-y-2">
                        <flux:input 
                            wire:model="name" 
                            :label="__('Full Name Alias')" 
                            type="text" 
                            required 
                            autofocus 
                            autocomplete="name" 
                            class="!bg-zinc-950 !border-zinc-800 !text-white !font-black !h-14 !px-6 !text-lg !rounded-xl focus:!border-violet-500 transition-all"
                        />
                         <p class="text-[8px] font-mono text-zinc-600 uppercase tracking-widest pl-2">System identifier for academy communications.</p>
                    </div>

                    <div class="space-y-2">
                        <flux:input 
                            wire:model="email" 
                            :label="__('Encrypted Email Hub')" 
                            type="email" 
                            required 
                            autocomplete="email" 
                            class="!bg-zinc-950 !border-zinc-800 !text-white !font-black !h-14 !px-6 !text-lg !rounded-xl focus:!border-violet-500 transition-all"
                        />
                        
                        @if ($this->hasUnverifiedEmail)
                            <div class="mt-4 p-4 rounded-xl bg-amber-500/5 border border-amber-500/20">
                                <flux:text class="!text-[10px] !font-black !text-amber-500 !uppercase !tracking-widest flex items-center gap-2">
                                    <flux:icon.exclamation-triangle class="w-4 h-4" />
                                    Security Verification Pending
                                </flux:text>
                                <flux:link class="!text-[10px] font-mono !text-amber-500/60 hover:!text-amber-500 uppercase tracking-widest mt-2 block" wire:click.prevent="resendVerificationNotification">
                                    >> Re-send Protocol Email
                                </flux:link>

                                @if (session('status') === 'verification-link-sent')
                                    <flux:text class="mt-2 !text-[9px] font-mono !text-emerald-500 uppercase tracking-widest">
                                        Verification sequence transmitted.
                                    </flux:text>
                                @endif
                            </div>
                        @endif
                        <p class="text-[8px] font-mono text-zinc-600 uppercase tracking-widest pl-2">Primary channel for data transmissions and alerts.</p>
                    </div>
                </div>

                {{-- Action Terminal --}}
                <div class="flex items-center gap-6 pt-6 border-t border-zinc-900">
                    <flux:button variant="filled" type="submit" class="!px-12 !py-6 !bg-violet-600 !hover:bg-violet-500 !text-white !font-black !text-[11px] !uppercase !tracking-[0.4em] !rounded-2xl !shadow-[0_0_30px_-10px_rgba(139,92,246,0.5)] !transition-all" data-test="update-profile-button">
                        Update Credentials
                    </flux:button>

                    <x-action-message class="me-3 font-mono text-[9px] text-emerald-500 uppercase tracking-widest" on="profile-updated">
                        [Protocol Synced]
                    </x-action-message>
                </div>
            </form>

            @if ($this->showDeleteUser)
                <div class="mt-20 pt-20 border-t border-zinc-900">
                    <div class="flex items-center gap-3 mb-8">
                        <flux:icon.trash class="w-5 h-5 text-red-500/50" />
                        <h3 class="text-sm font-black text-zinc-500 uppercase tracking-widest">Danger Zone // Termination</h3>
                    </div>
                    <livewire:pages::settings.delete-user-form />
                </div>
            @endif
        </div>
    </x-pages::settings.layout>
</section>
