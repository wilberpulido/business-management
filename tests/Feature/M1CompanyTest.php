<?php

namespace Tests\Feature;

use App\Livewire\Company\EnterpriseCurrencies;
use App\Livewire\Company\EnterpriseProfile;
use App\Livewire\Pages\App\Company\Profile;
use App\Models\Currency;
use App\Models\Enterprise;
use App\Models\User;
use Database\Seeders\CurrencySeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class M1CompanyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([RoleAndPermissionSeeder::class, CurrencySeeder::class]);
    }

    private function ownerWithEnterprise(): User
    {
        $owner = User::factory()->create();
        $owner->assignRole('owner');
        Enterprise::factory()->create(['user_id' => $owner->id]);

        return $owner;
    }

    // ── Profile tests ─────────────────────────────────────────────────────────

    public function test_owner_can_view_company_profile(): void
    {
        $owner = $this->ownerWithEnterprise();

        Livewire::actingAs($owner)
            ->test(EnterpriseProfile::class)
            ->assertStatus(200)
            ->assertSet('form.trade_name', $owner->enterprise->trade_name);
    }

    public function test_owner_can_update_company_data(): void
    {
        $owner = $this->ownerWithEnterprise();

        Livewire::actingAs($owner)
            ->test(EnterpriseProfile::class)
            ->set('form.trade_name', 'Updated Business Name')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('enterprises', [
            'id'         => $owner->enterprise->id,
            'trade_name' => 'Updated Business Name',
        ]);
    }

    public function test_user_without_permission_cannot_edit_company(): void
    {
        $cashier = User::factory()->create();
        $cashier->assignRole('cashier');

        Livewire::actingAs($cashier)
            ->test(Profile::class)
            ->assertForbidden();
    }

    // ── Currencies tests ───────────────────────────────────────────────────────

    public function test_owner_can_attach_currency(): void
    {
        $owner = $this->ownerWithEnterprise();
        $currency = Currency::first();

        Livewire::actingAs($owner)
            ->test(EnterpriseCurrencies::class)
            ->call('attach', $currency->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('currency_enterprise', [
            'enterprise_id' => $owner->enterprise->id,
            'currency_id'   => $currency->id,
        ]);
    }

    public function test_first_attached_currency_is_set_as_default(): void
    {
        $owner = $this->ownerWithEnterprise();
        $currency = Currency::first();

        Livewire::actingAs($owner)
            ->test(EnterpriseCurrencies::class)
            ->call('attach', $currency->id);

        $this->assertDatabaseHas('currency_enterprise', [
            'enterprise_id' => $owner->enterprise->id,
            'currency_id'   => $currency->id,
            'is_default'    => true,
        ]);
    }

    public function test_owner_can_detach_non_default_currency(): void
    {
        $owner = $this->ownerWithEnterprise();
        [$first, $second] = Currency::take(2)->get();

        $owner->enterprise->currencies()->attach($first->id, ['is_default' => true]);
        $owner->enterprise->currencies()->attach($second->id, ['is_default' => false]);

        Livewire::actingAs($owner)
            ->test(EnterpriseCurrencies::class)
            ->call('detach', $second->id)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('currency_enterprise', [
            'enterprise_id' => $owner->enterprise->id,
            'currency_id'   => $second->id,
        ]);
    }

    public function test_cannot_detach_default_currency(): void
    {
        $owner = $this->ownerWithEnterprise();
        $currency = Currency::first();
        $owner->enterprise->currencies()->attach($currency->id, ['is_default' => true]);

        Livewire::actingAs($owner)
            ->test(EnterpriseCurrencies::class)
            ->call('detach', $currency->id)
            ->assertSet('error', fn ($value) => $value !== null);

        $this->assertDatabaseHas('currency_enterprise', [
            'enterprise_id' => $owner->enterprise->id,
            'currency_id'   => $currency->id,
        ]);
    }

    public function test_owner_can_change_default_currency(): void
    {
        $owner = $this->ownerWithEnterprise();
        [$first, $second] = Currency::take(2)->get();

        $owner->enterprise->currencies()->attach($first->id, ['is_default' => true]);
        $owner->enterprise->currencies()->attach($second->id, ['is_default' => false]);

        Livewire::actingAs($owner)
            ->test(EnterpriseCurrencies::class)
            ->call('setDefault', $second->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('currency_enterprise', [
            'enterprise_id' => $owner->enterprise->id,
            'currency_id'   => $second->id,
            'is_default'    => true,
        ]);
        $this->assertDatabaseHas('currency_enterprise', [
            'enterprise_id' => $owner->enterprise->id,
            'currency_id'   => $first->id,
            'is_default'    => false,
        ]);
    }
}
