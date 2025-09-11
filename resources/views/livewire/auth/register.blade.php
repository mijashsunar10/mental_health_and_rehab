<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;


new #[Layout('components.layouts.auth')] class extends Component {
    use WithFileUploads;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $photo;
    //  public $password_confirmation;
    public $phone;     // ✅ add this
    public $address;   // ✅ add this
    public $dob;     

    /**
     * Handle an incoming registration request.
     */
public function register()
{
    $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'photo' => ['image', 'nullable'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        'phone' => ['nullable', 'string', 'max:20'],
        'address' => ['nullable', 'string', 'max:255'],
        'dob' => ['nullable', 'date'],
    ]);

    $validated['password'] = Hash::make($validated['password']);
    if ($this->photo) {
        $validated['photo'] = $this->photo->store("photos", "public");
    }

    $user = User::create($validated);

    event(new Registered($user));

    Auth::login($user);

    // Flash success message
    session()->flash('success', 'Registration successful! 🎉 Now you can buy the packages.');

    // Redirect back to the page where user clicked "Buy Now"
   $this->redirect(url('/admin/packages'));

}


}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Full name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <flux:input
            wire:model="phone"
            :label="__('Phone Number')"
            type="tel"
            required
            autocomplete="phone"
            placeholder="+9779812345678"
        />

                <flux:input
            wire:model="dob"
            :label="__('Date of Birth')"
            type="date"
            required
            autocomplete="bday"
            placeholder="YYYY-MM-DD"
        />


                <flux:input
            wire:model="address"
            :label="__('Address')"
            type="text"
            required
            autocomplete="street-address"
            placeholder="Kathmandu, Nepal"
        />


          <flux:input
            wire:model="photo"
            id="photo"
            :label="__('Choose a photo(Optional)')"
            type="file"
            name="photo" 
        />

        

        @if($photo)

        <img src="{{$photo->temporaryUrl()}}" class="h-16 w-16 object-cover rounded-full" alt="" width="80px">
        {{-- IN livewire when user uploaded a file then it is not immediately stored in the sever instead temporaryUrl() creates the temporary previrew of the url so we can review before getting uploaded.. --}}

        @endif

      

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

     <a href="{{ route('auth.google.redirect') }}" class="btn  shadow-sm rounded-md text-blue-900">
       <img height="200px" width="230px" src="{{asset('google.png')}}" alt="">
    </a>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        <span>{{ __('Already have an account?') }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
