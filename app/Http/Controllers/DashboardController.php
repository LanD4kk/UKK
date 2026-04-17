<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard() {

        $totalComplaints = Complaint::count();
        $progress = Complaint::where('status', 'In Progress')->count();
        $resolved = Complaint::where('status', 'Resolved')->count();
        $totalStaff = User::whereIn('role', ['student', 'staff'])->count();

        return response()->json([
            'stats' => [
                'total' => $totalComplaints,
                'progress' => $progress,
                'resolved' => $resolved,
                'total_staff' => $totalStaff,
            ]
        ]);
    }
}
