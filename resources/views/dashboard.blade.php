<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
        <div class="grid auto-rows-min gap-6 md:grid-cols-3">
            <livewire:total-progress />
            <livewire:completed-courses />
            <livewire:total-points />
        </div>
        <div class="glass-panel relative h-full flex-1 overflow-hidden rounded-2xl flex items-center justify-center">
            <h2 class="text-2xl font-medium text-slate-500 dark:text-slate-400">Continue Your Learning...</h2>
        </div>
    </div>
</x-layouts::app>
