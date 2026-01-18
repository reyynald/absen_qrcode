<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSession;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Handle QR Code scan - show attendance form directly
     */
    public function handleQRCode($token)
    {
        $session = AttendanceSession::where('qr_code_token', $token)->firstOrFail();

        // Check if session is still active
        if ($session->end_date && $session->end_date < now()) {
            return redirect('/')->with('error', 'Session telah berakhir');
        }

        // If user is admin, show attendance list for this session
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->route('admin.sessions.show', $session->id)
                ->with('info', 'Anda login sebagai Admin. Berikut daftar peserta yang hadir:');
        }

        // Otherwise, show attendance form (whether logged in or not)
        return $this->showForm($token);
    }

    /**
     * Show attendance form
     */
    public function showForm($token)
    {
        $session = AttendanceSession::where('qr_code_token', $token)->firstOrFail();

        // Check if session is still active
        if ($session->end_date && $session->end_date < now()) {
            return redirect('/')->with('error', 'Session telah berakhir');
        }

        return view('attendance.form', ['session' => $session]);
    }

    /**
     * Store attendance record
     */
    public function store(Request $request, $token)
    {
        $session = AttendanceSession::where('qr_code_token', $token)->firstOrFail();

        // Check if session is still active
        if ($session->end_date && $session->end_date < now()) {
            return redirect('/')->with('error', 'Session telah berakhir');
        }

        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'nim_nip' => 'required|string|max:255',
            'jam_datang' => 'required|date_format:H:i',
            'signature' => 'required|string',
        ]);

        // Create attendance record (no user_id needed - anonymous submission)
        $attendance = Attendance::create([
            'session_id' => $session->id,
            'user_id' => auth()->id() ?? null,
            'name' => $validated['name'],
            'email' => null,
            'phone' => null,
            'institution' => null,
            'jurusan' => $validated['jurusan'],
            'nim_nip' => $validated['nim_nip'],
            'jam_datang' => $validated['jam_datang'],
            'jam_pulang' => null,
            'signature' => $validated['signature'],
            'checked_in_at' => now(),
        ]);

        // Show success page with thank you message
        return view('attendance.success', [
            'session' => $session,
            'attendance' => $attendance
        ]);
    }

    /**
     * Show edit form for attendance record
     */
    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $session = $attendance->session;

        // Check if session is still active
        if ($session->end_date && $session->end_date < now()) {
            return redirect()->back()->with('error', 'Session telah berakhir, tidak dapat diedit');
        }

        return view('attendance.edit', [
            'attendance' => $attendance,
            'session' => $session
        ]);
    }

    /**
     * Update attendance record
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $session = $attendance->session;

        // Check if session is still active
        if ($session->end_date && $session->end_date < now()) {
            return redirect()->back()->with('error', 'Session telah berakhir, tidak dapat diedit');
        }

        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'jam_datang' => 'required|date_format:H:i',
        ]);

        // Update attendance record
        $attendance->update($validated);

        return redirect()->route('admin.sessions.show', $session->id)
            ->with('success', 'Data absen berhasil diperbarui');
    }

    /**
     * Delete attendance record
     */
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $session = $attendance->session;

        // Check if session is still active
        if ($session->end_date && $session->end_date < now()) {
            return redirect()->back()->with('error', 'Session telah berakhir, tidak dapat dihapus');
        }

        $attendance->delete();

        return redirect()->route('admin.sessions.show', $session->id)
            ->with('success', 'Data absen berhasil dihapus');
    }
}
