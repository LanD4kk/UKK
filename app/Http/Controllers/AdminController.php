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

    public function accounts(Request $request)
    {
        $query = User::whereIn('role', ['student', 'staff'])->latest('user_id');

        $users = $query->paginate(10)->withQueryString();

        return view('admin.account-management', compact('users'));
    }

    public function storeAccount(Request $request)
    {
        $request->validate([
            'role' => 'required|in:student,staff',
            'identity_number' => 'required|string|max:50|unique:users,identity_number',
            'full_name' => 'required|string|max:100',
            'class_name' => 'required_if:role,student|nullable|string|max:20',
            'phone_number' => 'nullable|string|max:15',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'identity_number' => $request->identity_number,
            'full_name' => $request->full_name,
            'class_name' => $request->role === 'student' ? $request->class_name : null,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'Akun berhasil ditambahkan.');
    }

    public function updateAccount(Request $request, $id)
    {
        $user = User::whereIn('role', ['student', 'staff'])->findOrFail($id);

        $request->validate([
            'role' => 'required|in:student,staff',
            'full_name' => 'required|string|max:100',
            'class_name' => 'required_if:role,student|nullable|string|max:20',
            'phone_number' => 'nullable|string|max:15',
        ]);

        $user->update([
            'role' => $request->role,
            'full_name' => $request->full_name,
            'class_name' => $request->role === 'student' ? $request->class_name : null,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->back()->with('success', 'Data akun berhasil diperbarui.');
    }

    public function destroyAccount($id)
    {
        $user = User::whereIn('role', ['student', 'staff'])->findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Akun beserta seluruh datanya berhasil dihapus secara permanen.');
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

        $aspirations = $query->paginate(15)->withQueryString();

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
            'action_photo' => 'nullable|file|image|max:5120',
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
                'user_id' => auth()->id() ?? 1,
                'message' => $messageText,
                'action_photo' => $photoPath,
            ]);
        }

        return redirect()->back()->with('success', 'Status dan feedback berhasil diperbarui.');
    }
}