<x-layouts.app :title="__('company.title')">

    <x-ui.breadcrumb :items="[
        ['label' => __('ui.navigation.dashboard'), 'route' => 'dashboard'],
        ['label' => __('company.title')],
    ]" />

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
            {{ __('company.title') }}
        </h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">
            {{ __('company.subtitle') }}
        </p>
    </div>

    <x-ui.tabs
        :items="[
            ['id' => 'profile',    'label' => __('company.tabs.profile')],
            ['id' => 'currencies', 'label' => __('company.tabs.currencies')],
        ]"
        url-param="tab"
    >
        <x-ui.tab-panel id="profile">
            <livewire:company.enterprise-profile />
        </x-ui.tab-panel>

        <x-ui.tab-panel id="currencies">
            <livewire:company.enterprise-currencies />
        </x-ui.tab-panel>
    </x-ui.tabs>

</x-layouts.app>
