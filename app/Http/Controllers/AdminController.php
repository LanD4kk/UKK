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

    public function storeStudent(Request $request)
    {
        $request->validate([
            'identity_number' => 'required|string|max:50|unique:users,identity_number',
            'full_name' => 'required|string|max:100',
            'class_name' => 'required|string|max:20',
            'phone_number' => 'nullable|string|max:15',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'identity_number' => $request->identity_number,
            'full_name' => $request->full_name,
            'class_name' => $request->class_name,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
            'role' => 'student',
        ]);

        return redirect()->back()->with('success', 'Akun siswa baru berhasil ditambahkan.');
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

    public function storeCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:100|unique:categories,category_name',
        ]);

        Category::create([
            'category_name' => $request->category_name,
        ]);

        return redirect()->back()->with('success', 'Kategori laporan berhasil ditambahkan.');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'category_name' => 'required|string|max:100|unique:categories,category_name,' . $id . ',category_id',
        ]);

        $category->update([
            'category_name' => $request->category_name,
        ]);

        return redirect()->back()->with('success', 'Kategori laporan berhasil diperbarui.');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);

        if ($category->complaints()->exists()) {
            return redirect()->back()->withErrors(['Kategori ini tidak dapat dihapus karena masih menampung laporan pengaduan dari siswa.']);
        }

        $category->delete();

        return redirect()->back()->with('success', 'Kategori laporan berhasil dihapus secara permanen.');
    }

    public function aspirations(Request $request)
    {
        $query = Complaint::with(['user', 'category'])
            ->latest('complaint_id');

        // Filter: tanggal mulai
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        // Filter: tanggal akhir
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter: kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter: NIS / nama siswa (cari di tabel users via relasi)
        if ($request->filled('student')) {
            $search = $request->student;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('identity_number', 'like', "%$search%")
                  ->orWhere('full_name', 'like', "%$search%");
            });
        }

        // Filter: bulan (format: YYYY-MM)
        if ($request->filled('month')) {
            [$year, $month] = explode('-', $request->month);
            $query->whereYear('created_at', $year)
                  ->whereMonth('created_at', $month);
        }

        // Filter: status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $aspirations = $query->paginate(15)->withQueryString();
        $categories  = Category::orderBy('category_name')->get();

        return view('admin.aspiration-management', compact('aspirations', 'categories'));
    }

    public function showAspiration($id)
    {
        $aspiration = Complaint::with(['user', 'category', 'responses.user'])->findOrFail($id);
        
        return view('admin.aspiration-detail', compact('aspiration'));
    }

    public function historiAspirasi(Request $request)
    {
        $query = Complaint::with(['user', 'category'])
            ->withCount('responses')
            ->whereIn('status', ['Resolved', 'Rejected'])
            ->latest('updated_at');

        // Filter: bulan
        if ($request->filled('month')) {
            [$year, $month] = explode('-', $request->month);
            $query->whereYear('updated_at', $year)
                  ->whereMonth('updated_at', $month);
        }

        // Filter: tanggal mulai
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        // Filter: tanggal akhir
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter: kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter: NIS / nama siswa
        if ($request->filled('student')) {
            $search = $request->student;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('identity_number', 'like', "%$search%")
                  ->orWhere('full_name', 'like', "%$search%");
            });
        }

        $histories      = $query->paginate(15)->withQueryString();
        $categories     = Category::orderBy('category_name')->get();
        $totalResolved  = Complaint::where('status', 'Resolved')->count();
        $totalRejected  = Complaint::where('status', 'Rejected')->count();
        $totalResponses = \App\Models\Response::count();

        return view('admin.histori-aspirasi', compact(
            'histories', 'categories',
            'totalResolved', 'totalRejected', 'totalResponses'
        ));
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
