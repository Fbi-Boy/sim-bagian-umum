<?php

namespace Tests\Feature\Authorization;

use App\Models\User;
use App\Modules\Organization\Models\OrganizationalUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationalUnitAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_redirected_to_login(): void
    {
        $this->get(route('organization.units.index'))->assertRedirect(route('login'));
    }

    public function test_user_without_permission_forbidden(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get(route('organization.units.index'))->assertForbidden();
    }

    public function test_user_with_permission_can_view(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('organization.units.view');
        $this->actingAs($user)->get(route('organization.units.index'))->assertOk();
    }
}