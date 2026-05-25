<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierAccountController extends Controller
{
    public function verifyAdmin(Request $request): JsonResponse
    {
        $code = $request->input('code');

        if ($code !== config('app.admin_access_code')) {
            return response()->json(['error' => 'Incorrect access code. Please try again.'], 403);
        }

        $admins = User::where('role', 'admin')
            ->select('id', 'name', 'username')
            ->orderBy('name')
            ->get();

        return response()->json(['admins' => $admins]);
    }

    public function verifyStaff(Request $request): JsonResponse
    {
        $code = $request->input('code');

        if ($code !== config('app.staff_access_code')) {
            return response()->json(['error' => 'Incorrect access code. Please try again.'], 403);
        }

        $staff = User::where('role', 'staff')
            ->select('id', 'name', 'username')
            ->orderBy('name')
            ->get();

        return response()->json(['staff' => $staff]);
    }

    public function customers(): JsonResponse
    {
        $customers = User::where('role', 'customer')
            ->select('id', 'name', 'username')
            ->orderBy('name')
            ->get();

        return response()->json(['customers' => $customers]);
    }
}
