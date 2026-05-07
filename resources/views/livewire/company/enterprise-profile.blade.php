<div>
    <x-ui.card>
        <x-slot:header>
            <h2 class="text-base font-semibold text-slate-900 dark:text-white">
                {{ __('company.profile.general_info') }}
            </h2>
        </x-slot:header>

        <form wire:submit="save" class="space-y-6">

            {{-- Basic info --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <x-forms.field
                    name="form.trade_name"
                    :label="__('company.fields.trade_name')"
                    wire:model="form.trade_name"
                    :placeholder="__('company.fields.trade_name_placeholder')"
                />
                <x-forms.field
                    name="form.business_name"
                    :label="__('company.fields.business_name')"
                    wire:model="form.business_name"
                />
                <x-forms.field
                    name="form.tax_id"
                    :label="__('company.fields.tax_id')"
                    wire:model="form.tax_id"
                />
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-3 pb-2 border-b border-gray-100 dark:border-slate-800">
                    {{ __('company.profile.contact') }}
                </h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <x-forms.field
                        name="form.phone"
                        :label="__('company.fields.phone')"
                        wire:model="form.phone"
                    />
                    <x-forms.field
                        name="form.email"
                        type="email"
                        :label="__('company.fields.email')"
                        wire:model="form.email"
                    />
                    <x-forms.field
                        name="form.website"
                        :label="__('company.fields.website')"
                        wire:model="form.website"
                        placeholder="https://"
                    />
                </div>
            </div>

            {{-- Address --}}
            <div class="pb-6">
                <h3 class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-3 pb-2 border-b border-gray-100 dark:border-slate-800">
                    {{ __('company.profile.address') }}
                </h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <x-forms.field
                            name="form.address"
                            :label="__('company.fields.address')"
                            wire:model="form.address"
                        />
                    </div>

                    <x-forms.combobox
                        name="form.state_id"
                        :label="__('company.fields.state')"
                        :options="$states"
                        :value="$this->form->state_id"
                        :searchable="true"
                        wire:model.live="form.state_id"
                    />

                    <x-forms.combobox
                        name="form.city_id"
                        :label="__('company.fields.city')"
                        :options="$cities"
                        :value="$this->form->city_id"
                        :searchable="true"
                        wire:model="form.city_id"
                        :disabled="! $this->form->state_id"
                    />
                </div>
            </div>

            <div class="flex justify-end pt-8 border-t border-gray-100 dark:border-slate-800">
                <x-ui.button
                    wire:loading.attr="disabled"
                    wire:target="save"
                    wire:loading.class="opacity-75"
                >
                    {{ __('ui.buttons.save') }}
                </x-ui.button>
            </div>

        </form>
    </x-ui.card>
</div>
