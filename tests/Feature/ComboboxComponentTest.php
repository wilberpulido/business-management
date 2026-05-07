<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class ComboboxComponentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        view()->share('errors', new ViewErrorBag());
    }

    private function render(string $props = '', array $data = []): string
    {
        return Blade::render("<x-forms.combobox {$props} />", $data);
    }

    public function test_renders_x_data_attribute(): void
    {
        $html = $this->render('name="field" :options="[]" :value="null"');
        $this->assertStringContainsString('x-data="combobox(', $html);
    }

    public function test_renders_options_as_json_in_data_options(): void
    {
        $options = [1 => 'State A', 2 => 'State B'];
        $html = $this->render('name="field" :options="$options" :value="null"', compact('options'));
        $this->assertStringContainsString('data-options=', $html);
        $this->assertStringContainsString('State A', $html);
        $this->assertStringContainsString('State B', $html);
    }

    public function test_renders_hidden_input_with_wire_model(): void
    {
        $html = $this->render('name="field" :options="[]" :value="null" wire:model="form.field"');
        $this->assertStringContainsString('type="hidden"', $html);
        $this->assertStringContainsString('wire:model="form.field"', $html);
    }

    public function test_renders_label_when_provided(): void
    {
        $html = $this->render('name="state_id" label="Province" :options="[]" :value="null"');
        $this->assertStringContainsString('Province', $html);
        $this->assertStringContainsString('for="state_id"', $html);
    }

    public function test_renders_search_input_when_searchable(): void
    {
        $html = $this->render('name="field" :options="[]" :value="null" :searchable="true"');
        $this->assertStringContainsString('x-ref="searchInput"', $html);
    }

    public function test_does_not_render_search_when_not_searchable(): void
    {
        $html = $this->render('name="field" :options="[]" :value="null" :searchable="false"');
        $this->assertStringNotContainsString('x-ref="searchInput"', $html);
    }

    public function test_passes_integer_value_to_alpine(): void
    {
        $html = $this->render('name="field" :options="[]" :value="5"');
        $this->assertStringContainsString('value: 5', $html);
    }

    public function test_passes_null_value_as_js_null(): void
    {
        $html = $this->render('name="field" :options="[]" :value="null"');
        $this->assertStringContainsString('value: null', $html);
    }

    public function test_handles_empty_options(): void
    {
        $html = $this->render('name="field" :options="[]" :value="null"');
        $this->assertStringContainsString('data-options="[]"', $html);
    }

    public function test_accepts_eloquent_collection(): void
    {
        $collection = collect([1 => 'Option A', 2 => 'Option B']);
        $html = $this->render('name="field" :options="$collection" :value="null"', compact('collection'));
        $this->assertStringContainsString('Option A', $html);
        $this->assertStringContainsString('Option B', $html);
    }
}
