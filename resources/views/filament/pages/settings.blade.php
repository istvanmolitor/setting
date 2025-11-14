<x-filament-panels::page>
    <div class="flex gap-4">
        <div class="w-1/4">
            <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-2 shadow-sm space-y-1">
                @foreach($tabs as $tab)
                    <button
                        wire:click="selectSettingTab('{{ $tab['slug'] }}')"
                        class="w-full text-left px-3 py-2 rounded flex items-center gap-2 {{ $settingSlug === $tab['slug'] ? 'bg-primary-100 text-primary-700' : 'hover:bg-gray-100' }}">
                        <x-filament::icon :icon="$tab['icon']" class="w-5 h-5 mr-1" /><span>{{ $tab['label'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>
        <div class="flex-1">
            <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-6 shadow-sm">
                @php
                    $activeLabel = null;
                    foreach ($tabs as $tab) {
                        if ($settingSlug === $tab['slug']) { $activeLabel = $tab['label']; break; }
                    }
                @endphp
                @if($activeLabel)
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ $activeLabel }}</h2>
                @endif

                {{ $this->form }}

                <div class="mt-4">
                    <x-filament::button wire:click="save">
                        Mentés
                    </x-filament::button>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>

