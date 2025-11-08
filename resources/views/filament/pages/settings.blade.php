<x-filament-panels::page>
    <div class="flex gap-4">
        <div class="w-1/4 space-y-1">
            @foreach(\Molitor\Setting\Models\SettingGroup::orderBy('name')->get() as $cat)
                <button
                    wire:click="$set('activeSettingGroupSlug', '{{ $cat->slug }}'); loadSettings()"
                    class="w-full text-left px-3 py-2 rounded {{ $activeSettingGroupSlug === $cat->slug ? 'bg-primary-100 text-primary-700' : 'hover:bg-gray-100' }}">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>
        <div class="flex-1">
            {{ $this->form }}

            <div class="mt-4">
                <x-filament::button wire:click="save">
                    Mentés
                </x-filament::button>
            </div>
        </div>
    </div>
</x-filament-panels::page>

