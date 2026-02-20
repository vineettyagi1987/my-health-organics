<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DistributorController extends Controller
{
    /**
     * List all distributors
     */
   public function index(Request $request)
{
    $query = User::where('role', User::ROLE_DISTRIBUTOR);

    // Apply search filter
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%")
              ->orWhere('phone', 'like', "%$search%")
              ->orWhere('dist_id', 'like', "%$search%")
              ->orWhere('region_area', 'like', "%$search%");
        });
    }

    $distributors = $query->latest()
        ->paginate(10)
        ->withQueryString(); // Keeps search during pagination

    return view('admin.distributors.index', compact('distributors'));
}


    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.distributors.create');
    }

    /**
     * Store distributor
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','max:255','unique:users,email'],
            'phone'    => ['required','string','max:20'],
            'password' => ['required','string','min:6'],
            'status'   => ['required','boolean'],
             'region_area'     => ['nullable','string','max:255'],
             'commission_rate' => ['nullable','numeric','min:0','max:100'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role']     = User::ROLE_DISTRIBUTOR;

        User::create($data);

        return redirect()
            ->route('admin.distributors.index')
            ->with('success', 'Distributor created successfully.');
    }

    /**
     * Edit distributor
     */
    public function edit($id)
    {
        $distributor = User::where('role', User::ROLE_DISTRIBUTOR)
            ->findOrFail($id);

        return view('admin.distributors.edit', compact('distributor'));
    }

    /**
     * Update distributor
     */
    public function update(Request $request, $id)
    {
        $distributor = User::where('role', User::ROLE_DISTRIBUTOR)
            ->findOrFail($id);

        $data = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','max:255','unique:users,email,' . $distributor->id],
            'phone'    => ['required','string','max:20'],
            'password' => ['nullable','string','min:6'],
            'status'   => ['required','boolean'],
            'region_area'     => ['nullable','string','max:255'],
             'commission_rate' => ['nullable','numeric','min:0','max:100'],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $distributor->update($data);

        return redirect()
            ->route('admin.distributors.index')
            ->with('success', 'Distributor updated successfully.');
    }

    /**
     * Delete distributor
     */
    public function destroy($id)
    {
        $distributor = User::where('role', User::ROLE_DISTRIBUTOR)
            ->findOrFail($id);

        $distributor->delete();

        return redirect()
            ->route('admin.distributors.index')
            ->with('success', 'Distributor deleted successfully.');
    }
}
