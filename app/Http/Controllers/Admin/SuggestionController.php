<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuggestionController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        $currentUserRole = $request->session()->get('role');
        $currentUserId = $request->session()->get('user_id');
        $currentUsername = $request->session()->get('username');

        // Pagination
        $page = (int) $request->input('page', 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        // Filter
        $status = $request->input('status', 'all');
        $search = $request->input('search', '');

        // Query dasar
        $query = DB::table('suggestions as s')
            ->leftJoin('users as u', 's.responded_by', '=', 'u.id')
            ->select('s.*', 'u.username as responder_name');

        $countQuery = DB::table('suggestions');

        // Apply filters
        if ($status !== 'all') {
            $query->where('s.status', $status);
            $countQuery->where('status', $status);
        }

        if (!empty($search)) {
            $searchTerm = "%$search%";
            $query->where(function ($q) use ($searchTerm) {
                $q->where('s.name', 'like', $searchTerm)
                    ->orWhere('s.email', 'like', $searchTerm)
                    ->orWhere('s.message', 'like', $searchTerm);
            });
            $countQuery->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm)
                    ->orWhere('message', 'like', $searchTerm);
            });
        }

        // Get total count
        $totalSuggestions = $countQuery->count();
        $totalPages = ceil($totalSuggestions / $limit);

        // Get suggestions
        $suggestions = $query->orderBy('s.created_at', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        // Stats
        $stats = [
            'total' => DB::table('suggestions')->count(),
            'pending' => DB::table('suggestions')->where('status', 'pending')->count(),
            'read_count' => DB::table('suggestions')->where('status', 'read')->count(),
            'responded' => DB::table('suggestions')->where('status', 'responded')->count(),
        ];

        return view('admin.suggestions', compact(
            'suggestions',
            'stats',
            'page',
            'totalPages',
            'totalSuggestions',
            'status',
            'search',
            'limit',
            'offset',
            'currentUserRole',
            'currentUserId',
            'currentUsername'
        ));
    }

    public function updateStatus(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        $userId = $request->session()->get('user_id');

        $action = $request->input('action', '');
        $suggestionId = (int) $request->input('suggestion_id', 0);

        if ($action === 'update_status') {
            $newStatus = $request->input('status', '');
            $responseText = $request->input('response', '');

            // Validasi: tidak bisa mengubah dari 'read' atau 'responded' ke 'pending'
            $currentStatus = DB::table('suggestions')->where('id', $suggestionId)->value('status');

            if (in_array($currentStatus, ['read', 'responded']) && $newStatus === 'pending') {
                return redirect('/admin/saran')->with('error', "Tidak bisa mengubah status kembali ke 'pending' setelah dibaca.");
            }

            if (in_array($newStatus, ['pending', 'read', 'responded'])) {
                DB::table('suggestions')->where('id', $suggestionId)->update([
                    'status' => $newStatus,
                    'response' => $responseText,
                    'responded_by' => $userId,
                    'responded_at' => now(),
                ]);

                return redirect('/admin/saran')->with('success', 'Status saran berhasil diperbarui');
            }
        } elseif ($action === 'delete' && $request->session()->get('role') === 'superadmin') {
            DB::table('suggestions')->where('id', $suggestionId)->delete();
            return redirect('/admin/saran')->with('success', 'Saran berhasil dihapus');
        } elseif ($action === 'delete_all' && $request->session()->get('role') === 'superadmin') {
            $confirm = $request->input('confirm_delete_all') === '1';
            if ($confirm) {
                DB::table('suggestions')->truncate();
                return redirect('/admin/saran')->with('success', 'Semua saran berhasil dihapus');
            }
            return redirect('/admin/saran')->with('error', 'Konfirmasi penghapusan tidak valid');
        }

        return redirect('/admin/saran');
    }
}
