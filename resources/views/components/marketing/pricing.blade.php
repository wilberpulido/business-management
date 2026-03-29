@php
    // Valores por defecto si no se envían desde el controlador
    $plans = $plans ?? [
        'free' => [
            'name' => 'Starter',
            'price' => '0',
            'description' => 'Perfecto para proyectos personales y experimentación.',
            'features' => [
                'Hasta 3 proyectos activos',
                '1 GB de almacenamiento',
                'Soporte por comunidad',
                'Actualizaciones semanales'
            ],
            'button' => 'Empezar Gratis',
            'featured' => false,
        ],
        'pro' => [
            'name' => 'Pro Business',
            'price' => '29',
            'description' => 'Diseñado para equipos que buscan velocidad y potencia.',
            'features' => [
                'Proyectos ilimitados',
                '50 GB de almacenamiento',
                'Soporte prioritario 24/7',
                'Acceso a la API avanzada',
                'Reportes personalizados'
            ],
            'button' => 'Prueba Gratuita',
            'featured' => true,
        ],
    ];
@endphp
<section id="pricing" class="py-16 bg-transparent transition-colors duration-300">
    <x-ui.background-blobs />
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white">
                {{ __('pricing.title') }}
            </h2>
            <p class="mt-4 text-slate-600 dark:text-slate-400">
                {{ __('pricing.subtitle') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            {{-- __('pricing.plans') --}}
            @foreach( $plans as $key => $plan)
                <div class="relative p-8 rounded-2xl border transition-all
                    {{ $plan['featured']
                        ? 'border-blue-500 ring-2 ring-blue-500/20 bg-blue-50/30 dark:bg-blue-900/10'
                        : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800'
                    }}">

                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white">{{ $plan['name'] }}</h3>
                    <div class="mt-4 flex items-baseline">
                        <span class="text-4xl font-bold text-slate-900 dark:text-white">${{ $plan['price'] }}</span>
                        <span class="ml-1 text-slate-500 dark:text-slate-400">/mes</span>
                    </div>
                    <p class="mt-4 text-sm text-slate-600 dark:text-slate-400">{{ $plan['description'] }}</p>

                    <ul class="mt-6 space-y-4">
                        @foreach($plan['features'] as $feature)
                            <li class="flex items-center text-sm text-slate-600 dark:text-slate-300">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>

                    <button class="mt-8 w-full py-3 px-6 rounded-xl font-medium transition-colors
                        {{ $plan['featured']
                            ? 'bg-blue-600 text-white hover:bg-blue-700'
                            : 'bg-slate-100 dark:bg-slate-700 text-slate-900 dark:text-white hover:bg-slate-200 dark:hover:bg-slate-600'
                        }}">
                        {{ $plan['button'] }}
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</section>
