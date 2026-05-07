<div>
    @if ($error)
        <x-ui.alert type="error" class="mb-6">
            {{ $error }}
        </x-ui.alert>
    @endif

    <x-ui.card :padding="'none'">
        <x-slot:header>
            <h2 class="text-base font-semibold text-slate-900 dark:text-white">
                {{ __('company.currencies.catalog') }}
            </h2>
        </x-slot:header>

        <div class="divide-y divide-gray-100 dark:divide-slate-800">
            @foreach ($this->currencyList as $currency)
                <div class="flex items-center justify-between px-6 py-4 gap-4">

                    <div class="flex items-center gap-4 min-w-0">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-50 dark:bg-indigo-950 flex items-center justify-center">
                            <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">
                                {{ $currency->symbol }}
                            </span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-900 dark:text-white truncate">
                                {{ $currency->name }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-slate-400">
                                {{ $currency->code }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 flex-shrink-0">

                        @if ($currency->is_default_for_enterprise)
                            <x-ui.badge color="indigo">
                                {{ __('company.currencies.default') }}
                            </x-ui.badge>
                        @elseif ($currency->is_active)
                            <x-ui.badge color="green">
                                {{ __('company.currencies.active') }}
                            </x-ui.badge>
                        @endif

                        @if ($currency->is_active)
                            @unless ($currency->is_default_for_enterprise)
                                <x-ui.button
                                    variant="secondary"
                                    size="sm"
                                    wire:click="setDefault({{ $currency->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="setDefault({{ $currency->id }})"
                                >
                                    {{ __('company.currencies.set_default') }}
                                </x-ui.button>
                                <x-ui.button
                                    variant="ghost"
                                    size="sm"
                                    wire:click="detach({{ $currency->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="detach({{ $currency->id }})"
                                >
                                    {{ __('company.currencies.remove') }}
                                </x-ui.button>
                            @endunless
                        @else
                            <x-ui.button
                                variant="secondary"
                                size="sm"
                                wire:click="attach({{ $currency->id }})"
                                wire:loading.attr="disabled"
                                wire:target="attach({{ $currency->id }})"
                            >
                                {{ __('company.currencies.add') }}
                            </x-ui.button>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    </x-ui.card>
</div>
