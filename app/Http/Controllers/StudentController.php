<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Tampilkan halaman dashboard siswa.
     */
    public function dashboard()
    {
        return view('student.dashboard');
    }

    /**
     * API: Ambil data ringkasan dashboard siswa yang sedang login.
     */
    public function apiDashboard(Request $request)
    {
        $user = Auth::user();

        // 1. Hitung stats keseluruhan (tidak mempedulikan filter)
        $allComplaints = Complaint::where('user_id', $user->user_id)->get();
        $total      = $allComplaints->count();
        $pending    = $allComplaints->where('status', 'Pending')->count();
        $inProgress = $allComplaints->where('status', 'In Progress')->count();
        $resolved   = $allComplaints->where('status', 'Resolved')->count();
        $rejected   = $allComplaints->where('status', 'Rejected')->count();

        // 2. Query data riwayat dengan filter
        $query = Complaint::with(['category', 'responses'])
            ->where('user_id', $user->user_id)
            ->latest();

        if ($request->filled('month')) {
            $month = substr($request->month, 5, 2);
            $year = substr($request->month, 0, 4);
            $query->whereMonth('created_at', $month)
                  ->whereYear('created_at', $year);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $filteredComplaints = $query->get()->map(function ($c) {
            return [
                'id'           => $c->complaint_id,
                'title'        => $c->title,
                'status'       => $c->status,
                'category'     => $c->category?->category_name ?? 'Uncategorized',
                'responses'    => $c->responses->count(),
                'created_at'   => $c->created_at->diffForHumans(),
                'created_raw'  => $c->created_at->toIso8601String(),
                'created_date' => $c->created_at->format('d M Y, H:i'),
            ];
        });

        return response()->json([
            'user' => [
                'full_name'       => $user->full_name,
                'identity_number' => $user->identity_number,
                'class_name'      => $user->class_name,
                'role'            => $user->role,
            ],
            'stats' => [
                'total'      => $total,
                'pending'    => $pending,
                'in_progress'=> $inProgress,
                'resolved'   => $resolved,
                'rejected'   => $rejected,
            ],
            'complaints' => $filteredComplaints,
        ]);
    }

    /**
     * API: Ambil detail satu laporan milik siswa yang sedang login.
     */
    public function apiReportDetail($id)
    {
        $user = Auth::user();

        $complaint = Complaint::with(['category', 'user', 'responses.user'])
            ->where('complaint_id', $id)
            ->where('user_id', $user->user_id)
            ->first();

        if (!$complaint) {
            return response()->json(['message' => 'Laporan tidak ditemukan.'], 404);
        }

        $responses = $complaint->responses->map(function ($r) {
            return [
                'id'           => $r->response_id,
                'message'      => $r->message,
                'action_photo' => $r->action_photo ? asset('storage/' . $r->action_photo) : null,
                'responder'    => $r->user?->full_name ?? 'Admin',
                'role'         => $r->user?->role ?? 'Staff',
                'created_at'   => $r->created_at->diffForHumans(),
                'created_raw'  => $r->created_at->toIso8601String(),
            ];
        });

        return response()->json([
            'complaint' => [
                'id'             => $complaint->complaint_id,
                'title'          => $complaint->title,
                'description'    => $complaint->description,
                'status'         => $complaint->status,
                'category'       => $complaint->category?->category_name ?? 'Uncategorized',
                'evidence_photo' => $complaint->evidence_photo ? asset('storage/' . $complaint->evidence_photo) : null,
                'created_at'     => $complaint->created_at->diffForHumans(),
                'created_raw'    => $complaint->created_at->toIso8601String(),
                'reporter'       => $complaint->user?->full_name ?? $user->full_name,
            ],
            'responses' => $responses,
        ]);
    }

    /**
     * API: Ambil daftar kategori.
     */
    public function apiCategories()
    {
        $categories = Category::orderBy('category_name')->get(['category_id', 'category_name']);
        return response()->json($categories);
    }

    /**
     * API: Simpan laporan baru ke database.
     */
    public function storeReport(Request $request)
    {
        $request->validate([
            'category_id'   => 'required|exists:categories,category_id',
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'evidence_photo'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $photoPath = null;
        if ($request->hasFile('evidence_photo')) {
            $photoPath = $request->file('evidence_photo')->store('complaints', 'public');
        }

        $complaint = Complaint::create([
            'user_id'       => Auth::user()->user_id,
            'category_id'   => $request->category_id,
            'title'         => $request->title,
            'description'   => $request->description,
            'evidence_photo'=> $photoPath,
            'status'        => 'Pending',
        ]);

        return response()->json([
            'message'      => 'Laporan berhasil dikirim.',
            'complaint_id' => $complaint->complaint_id,
        ], 201);
    }
}
