<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\User;
use App\Models\Category;
use App\Models\Response;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalComplaints = Complaint::count();
        $needVerification = Complaint::where('status', 'Pending')->count();
        $resolvedCases = Complaint::where('status', 'Resolved')->count();
        $activeStaff = User::whereIn('role', ['admin', 'staff'])->count();

        $complaints = Complaint::with(['user', 'category'])
            ->latest()
            ->paginate(10);

        return view('admin.admin-dashboard', compact(
            'totalComplaints', 
            'needVerification', 
            'resolvedCases', 
            'activeStaff', 
            'complaints'
        ));
    }

    public function students(Request $request)
    {
        $students = User::where('role', 'student')->latest('user_id')->paginate(10);
        return view('admin.student-management', compact('students'));
    }

    public function updateStudent(Request $request, $id)
    {
        $student = User::where('role', 'student')->findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:100',
            'class_name' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:15',
        ]);

        $student->update([
            'full_name' => $request->full_name,
            'class_name' => $request->class_name,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroyStudent($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $student->delete();

        return redirect()->back()->with('success', 'Akun siswa beserta seluruh data laporannya berhasil dihapus secara permanen.');
    }

    public function categories(Request $request)
    {
        $categories = Category::withCount('complaints')->paginate(10);
        return view('admin.category-management', compact('categories'));
    }

    public function aspirations(Request $request)
    {
        $aspirations = Complaint::with(['user', 'category'])->latest('complaint_id')->paginate(10);
        return view('admin.aspiration-management', compact('aspirations'));
    }

    public function showAspiration($id)
    {
        $aspiration = Complaint::with(['user', 'category', 'responses.user'])->findOrFail($id);
        
        return view('admin.aspiration-detail', compact('aspiration'));
    }

    public function updateAspiration(Request $request, $id)
    {
        $aspiration = Complaint::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Pending,In Progress,Resolved,Rejected',
            'message' => 'nullable|string',
            'action_photo' => 'nullable|file|image|max:5120', // Tingkatkan limit ke 5MB agar aman
        ]);

        $aspiration->update([
            'status' => $request->status
        ]);

        $messageText = trim($request->input('message') ?? '');
        $hasPhoto = $request->hasFile('action_photo') && $request->file('action_photo')->isValid();

        if ($messageText !== '' || $hasPhoto) {
            $photoPath = null;
            if ($hasPhoto) {
                $photoPath = $request->file('action_photo')->store('responses', 'public');
            }

            Response::create([
                'complaint_id' => $aspiration->complaint_id,
                'user_id' => auth()->id() ?? 1, // Fallback ID 1 jika session auth gagal terdeteksi
                'message' => $messageText,
                'action_photo' => $photoPath,
            ]);
        }

        return redirect()->back()->with('success', 'Status dan feedback berhasil diperbarui.');
    }
}
