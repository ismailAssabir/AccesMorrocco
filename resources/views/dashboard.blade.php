<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

   <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-[#be2346]/10">
            <div class="p-8 text-gray-900">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-1.5 h-8 bg-[#be2346] rounded-full"></div>
                    <h3 class="text-xl font-bold tracking-tight">Bienvenue, {{ Auth::user()->firstName }}</h3>
                </div>
                
                <p class="text-gray-500 font-medium">
                    {{ __("Vous êtes connecté à votre espace de gestion Access Morocco.") }}
                </p>
            </div>
        </div>

        
    </div>
</div>
</x-app-layout>
