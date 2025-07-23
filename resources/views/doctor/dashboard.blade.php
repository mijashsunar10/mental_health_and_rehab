<x-layouts.app :title="__('Admin_Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
     <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Dashboard') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage modules') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

        <p>Hi I m doctor</p>


    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif
    
    </div>
</x-layouts.app>