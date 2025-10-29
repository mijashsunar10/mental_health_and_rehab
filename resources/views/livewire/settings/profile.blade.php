<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public ?string $phone = '';
    public ?string $address = '';
    public ?string $dob = '';
    public ?string $nmc_number = '';
    public $photo;
    public ?string $current_photo = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->address = $user->address ?? '';
        $this->dob = $user->dob ?? '';
        $this->nmc_number = $user->nmc_number ?? '';
        $this->current_photo = $user->photo;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'dob' => ['nullable', 'date'],
            'photo' => ['nullable', 'image', 'max:2048'], // 2MB max
        ];

        // Add NMC number validation for doctors
        if ($user->role->value === 'doctor') {
            $rules['nmc_number'] = ['nullable', 'string', 'max:100'];
        }

        $validated = $this->validate($rules);

        // Handle photo upload
        if ($this->photo) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $photoPath = $this->photo->store('photos', 'public');
            $validated['photo'] = $photoPath;
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->current_photo = $user->photo;
        $this->photo = null;

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
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your personal information and contact details')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">

            <!-- Photo Upload -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Profile Photo</label>

                @if ($current_photo)
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ asset('storage/' . $current_photo) }}" alt="Current photo" class="w-24 h-24 rounded-full object-cover border-2 border-gray-300">
                        <div class="text-sm text-gray-600 dark:text-gray-400">Current Photo</div>
                    </div>
                @endif

                @if ($photo)
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ $photo->temporaryUrl() }}" alt="New photo preview" class="w-24 h-24 rounded-full object-cover border-2 border-blue-500">
                        <div class="text-sm text-gray-600 dark:text-gray-400">New Photo Preview</div>
                    </div>
                @endif

                <input type="file" wire:model="photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">

                @error('photo')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <p class="text-xs text-gray-500 dark:text-gray-400">Recommended: Square image, max 2MB</p>
            </div>

            <!-- Name -->
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <!-- Email -->
            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Phone -->
            <flux:input wire:model="phone" :label="__('Phone Number')" type="tel" autocomplete="tel" placeholder="e.g., 9826115361" />

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                <textarea
                    wire:model="address"
                    id="address"
                    rows="3"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:focus:ring-blue-800"
                    placeholder="Enter your full address"
                ></textarea>
                @error('address')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Date of Birth -->
            <flux:input wire:model="dob" :label="__('Date of Birth')" type="date" autocomplete="bday" />

            <!-- NMC Number (Only for Doctors) -->
            @if(auth()->user()->role->value === 'doctor')
                <flux:input
                    wire:model="nmc_number"
                    :label="__('NMC Number')"
                    type="text"
                    placeholder="Enter your Nepal Medical Council registration number"
                />
            @endif

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save Changes') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
