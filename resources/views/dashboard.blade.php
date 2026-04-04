<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
        <div class="grid auto-rows-min gap-6 md:grid-cols-3">
            <livewire:total-progress />
            <livewire:completed-courses />
            <livewire:total-points />
        </div>
        <div class="mt-4">
            <livewire:continue-learning />
        </div>
    </div>
</x-layouts::app>
