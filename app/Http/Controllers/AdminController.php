<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSession;
use App\Models\Attendance;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AdminController extends Controller
{
    /**
     * Dashboard admin
     */
    public function dashboard()
    {
        $totalSessions = AttendanceSession::count();
        $totalAttendance = Attendance::count();
        $recentSessions = AttendanceSession::latest()->take(5)->get();

        return view('admin.dashboard', [
            'totalSessions' => $totalSessions,
            'totalAttendance' => $totalAttendance,
            'recentSessions' => $recentSessions,
        ]);
    }

    /**
     * List all sessions
     */
    public function sessions()
    {
        $sessions = AttendanceSession::with('creator', 'attendances')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.sessions.index', ['sessions' => $sessions]);
    }

    /**
     * Show create session form
     */
    public function createSession()
    {
        return view('admin.sessions.create');
    }

    /**
     * Store new session
     */
    public function storeSession(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $session = new AttendanceSession($validated);
        $session->qr_code_token = $session->generateQRCodeToken();
        $session->created_by = 1; 
        $session->save();

        return redirect()->route('admin.sessions.show', $session->id)
            ->with('success', 'Sesi absen berhasil dibuat');
    }

    /**
     * Show session detail
     */
    public function showSession($id)
    {
        $session = AttendanceSession::with('attendances', 'creator')->findOrFail($id);
        $attendances = $session->attendances()->paginate(20);

        return view('admin.sessions.show', [
            'session' => $session,
            'attendances' => $attendances,
        ]);
    }


    public function generateQRCode($id)
{
    $session = AttendanceSession::findOrFail($id);
    $attendanceUrl = route('attendance.form', $session->qr_code_token);

    return view('admin.sessions.qrcode', [
        'session' => $session,
        'attendanceUrl' => $attendanceUrl,
    ]);
}

    /**
     * Delete session
     */
    public function deleteSession($id)
    {
        $session = AttendanceSession::findOrFail($id);

        if ($session->created_by !== auth()->id() && (!auth()->user() || !auth()->user()->is_admin)) {
            abort(403);
        }

        $session->delete();

        return redirect()->route('admin.sessions')
            ->with('success', 'Sesi berhasil dihapus');
    }

    /**
     * Export attendance as Excel
     */
    public function exportAttendance($id)
    {
        $session = AttendanceSession::with('attendances')->findOrFail($id);
        $attendances = $session->attendances()->get();

        // Create spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Absen');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);

        // Title row
        $sheet->setCellValue('A1', 'LAPORAN KEHADIRAN');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension('1')->setRowHeight(25);

        // Info rows
        $sheet->setCellValue('A3', 'Nama Sesi');
        $sheet->setCellValue('B3', $session->name);
        
        $sheet->setCellValue('A4', 'Tanggal Export');
        $sheet->setCellValue('B4', date('d-m-Y H:i:s'));
        
        $sheet->setCellValue('A5', 'Total Peserta');
        $sheet->setCellValue('B5', count($attendances));

        // Header row
        $headerRow = 7;
        $headers = ['No', 'Nama Lengkap', 'Jurusan / Jabatan', 'NIM / NIP', 'Jam Datang', 'Tanda Tangan'];
        $columns = ['A', 'B', 'C', 'D', 'E', 'F'];
        
        foreach ($headers as $col => $header) {
            $cellRef = $columns[$col] . $headerRow;
            $sheet->setCellValue($cellRef, $header);
            
            // Style header
            $sheet->getStyle($cellRef)->getFont()->setBold(true)->setColor(new Color('FFFFFF'));
            $sheet->getStyle($cellRef)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF4472C4');
            $sheet->getStyle($cellRef)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($cellRef)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        }
        $sheet->getRowDimension($headerRow)->setRowHeight(20);

        // Data rows
        $row = $headerRow + 1;
        $i = 1;
        foreach ($attendances as $attendance) {
            $sheet->setCellValue('A' . $row, str_pad($i++, 3, '0', STR_PAD_LEFT));
            $sheet->setCellValue('B' . $row, strtoupper($attendance->name));
            $sheet->setCellValue('C' . $row, $attendance->jurusan ?? '-');
            $sheet->setCellValue('D' . $row, $attendance->nim_nip ?? '-');
            $sheet->setCellValue('E' . $row, $attendance->jam_datang ?? '-');
            $sheet->setCellValue('F' . $row, $attendance->signature ? 'Ada' : '-');

            // Style data row
            for ($col = 0; $col < 6; $col++) {
                $cellRef = $columns[$col] . $row;
                $sheet->getStyle($cellRef)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle($cellRef)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            }

            $row++;
        }

        // Create file
        $filename = 'Laporan_Absen_' . str_replace(' ', '_', $session->name) . '_' . date('d-m-Y') . '.xlsx';
        
        $writer = new Xlsx($spreadsheet);
        $temp_file = tempnam(sys_get_temp_dir(), 'excel_');
        $writer->save($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
    }
}
