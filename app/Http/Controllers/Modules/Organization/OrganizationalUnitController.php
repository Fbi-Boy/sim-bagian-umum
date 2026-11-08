<?php

namespace App\Http\Controllers\Modules\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Modules\Organization\StoreOrganizationalUnitRequest;
use App\Modules\Organization\Models\OrganizationalUnit;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrganizationalUnitController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', OrganizationalUnit::class);
        $units = OrganizationalUnit::with('parent')->orderBy('name')->paginate(20);
        return view('modules.organization.units.index', compact('units'));
    }

    public function create(): View
    {
        $this->authorize('create', OrganizationalUnit::class);
        $parents = OrganizationalUnit::active()->orderBy('name')->get();
        return view('modules.organization.units.create', compact('parents'));
    }

    public function store(StoreOrganizationalUnitRequest $request): RedirectResponse
    {
        $this->authorize('create', OrganizationalUnit::class);
        OrganizationalUnit::create($request->validated());
        return redirect()->route('organization.units.index')->with('success', 'Unit berhasil dibuat.');
    }
}