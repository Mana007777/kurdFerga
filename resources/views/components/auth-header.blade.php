@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center space-y-2">
    <flux:heading size="xl" class="!text-white !tracking-tighter !font-black !uppercase">{{ $title }}</flux:heading>
    <flux:subheading class="!text-zinc-500 !font-mono !text-[10px] !uppercase !tracking-widest">{{ $description }}</flux:subheading>
</div>
