<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Edit Profil Member
    </h1>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        {{ $this->form }}

        <div class="mt-6 text-right">
            <x-filament::button wire:click="save" color="primary">
                Simpan Perubahan
            </x-filament::button>
        </div>
    </div>
</div>
