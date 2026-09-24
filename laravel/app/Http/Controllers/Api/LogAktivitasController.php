<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index()
    {
        return response()->json(
            LogAktivitas::with('user')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'aktivitas' => ['required', 'string'],
        ]);

        return response()->json(LogAktivitas::create($data), 201);
    }

    public function show(LogAktivitas $logAktivitas)
    {
        return response()->json(
            $logAktivitas->load('user')
        );
    }

    public function update(Request $request, LogAktivitas $logAktivitas)
    {
        $data = $request->validate([
            'user_id' => ['sometimes', 'exists:users,id'],
            'aktivitas' => ['sometimes', 'string'],
        ]);

        $logAktivitas->update($data);

        return response()->json($logAktivitas);
    }

    public function destroy(LogAktivitas $logAktivitas)
    {
        $logAktivitas->delete();

        return response()->json([
            'message' => 'Log aktivitas berhasil dihapus.',
        ]);
    }
}
