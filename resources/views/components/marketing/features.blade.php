@php
    $features = [
        [
            'title' => 'Despliegue Instantáneo',
            'description' => 'Envía tu código a producción en segundos con nuestra integración nativa de CI/CD.',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 22.5 12 13.5H3.75z" />',
            'color' => 'text-yellow-500',
        ],
        [
            'title' => 'Seguridad Nivel Enterprise',
            'description' => 'Encriptación de extremo a extremo y cumplimiento con estándares internacionales de seguridad.',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />',
            'color' => 'text-blue-500',
        ],
        [
            'title' => 'Colaboración en Tiempo Real',
            'description' => 'Invita a tu equipo y trabajen juntos en los mismos proyectos con sincronización instantánea.',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />',
            'color' => 'text-indigo-500',
        ],
        [
            'title' => 'Analíticas Avanzadas',
            'description' => 'Toma decisiones basadas en datos con nuestros dashboards personalizables y reportes automáticos.',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />',
            'color' => 'text-green-500',
        ],
    ];
@endphp

<section id="features" class="relative py-24 sm:py-32 overflow-hidden">
    <x-ui.background-blobs />
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:text-center">
            <h2 class="text-base font-semibold leading-7 text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">
                {{ __('features.pre-title') }}
            </h2>
            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                {{ __('features.title') }}
            </p>
            <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-slate-400">
                {{ __('features.subtitle') }}
            </p>
        </div>

        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
            <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-2">
                @foreach($features as $feature)
                    <div class="relative pl-16 group">
                        <dt class="text-base font-semibold leading-7 text-gray-900 dark:text-white">
                            <div @class([
                                'absolute left-0 top-0 flex h-12 w-12 items-center justify-center rounded-xl transition-all duration-300 group-hover:scale-110 shadow-lg',
                                'bg-indigo-600 dark:bg-indigo-500' => !isset($feature['color']),
                                'bg-slate-100 dark:bg-slate-800' => isset($feature['color']),
                            ])>
                                <svg @class(['h-6 w-6', $feature['color'] ?? 'text-white']) fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    {!! $feature['icon'] !!}
                                </svg>
                            </div>
                            {{ $feature['title'] }}
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600 dark:text-slate-400">
                            {{ $feature['description'] }}
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</section>
