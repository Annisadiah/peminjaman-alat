<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(
            User::query()
                ->select([
                    'id',
                    'name',
                    'email',
                    'role',
                    'no_hp',
                    'alamat',
                    'foto_profile',
                    'created_at',
                    'updated_at',
                ])
                ->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,petugas,peminjaman'],
            'no_hp' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'foto_profile' => ['nullable', 'string', 'max:255'],
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json($user->makeHidden('password'), 201);
    }

    public function show(User $user)
    {
        return response()->json($user->makeHidden('password'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['sometimes', 'string', 'min:8'],
            'role' => ['sometimes', 'in:admin,petugas,peminjaman'],
            'no_hp' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'foto_profile' => ['nullable', 'string', 'max:255'],
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json($user->makeHidden('password'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'User berhasil dihapus.',
        ]);
    }
}
