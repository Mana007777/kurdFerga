<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
        <div class="grid auto-rows-min gap-6 md:grid-cols-3">
            <div class="glass-panel relative aspect-video overflow-hidden rounded-2xl flex items-center justify-center group hover:scale-[1.02] transition-transform duration-300">
                <div class="absolute inset-0 bg-blue-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <h3 class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">Total Progress</h3>
            </div>
            <div class="glass-panel relative aspect-video overflow-hidden rounded-2xl flex items-center justify-center group hover:scale-[1.02] transition-transform duration-300">
                <div class="absolute inset-0 bg-indigo-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <h3 class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">Courses Completed</h3>
            </div>
            <div class="glass-panel relative aspect-video overflow-hidden rounded-2xl flex items-center justify-center group hover:scale-[1.02] transition-transform duration-300">
                <div class="absolute inset-0 bg-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white"><span class="text-purple-600 dark:text-purple-400">{{ \App\Models\User::first()->pts ?? 0 }}</span> pts</h3>
            </div>
        </div>
        <div class="glass-panel relative h-full flex-1 overflow-hidden rounded-2xl flex items-center justify-center">
            <h2 class="text-2xl font-medium text-slate-500 dark:text-slate-400">Continue Your Learning...</h2>
        </div>
    </div>
</x-layouts::app>
