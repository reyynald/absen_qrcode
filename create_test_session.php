<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Boot the application
$app->boot();

// Create a test session
use App\Models\AttendanceSession;
use App\Models\User;

$admin = User::where('email', 'admin@example.com')->first();

if ($admin) {
    $session = AttendanceSession::create([
        'name' => 'Test Session - QR Code Demo',
        'description' => 'Sesi test untuk demo QR Code scanning',
        'start_date' => now(),
        'end_date' => now()->addDays(7),
        'created_by' => $admin->id,
    ]);
    
    // Generate QR token
    $session->qr_code_token = md5(uniqid() . time());
    $session->save();
    
    echo "✅ Session Created Successfully!\n";
    echo "Session ID: " . $session->id . "\n";
    echo "Session Name: " . $session->name . "\n";
    echo "QR Token: " . $session->qr_code_token . "\n";
    echo "QR Code URL: http://127.0.0.1:8000/absen/" . $session->qr_code_token . "\n";
    echo "\n📱 Scan this link or open in browser:\n";
    echo "http://127.0.0.1:8000/absen/" . $session->qr_code_token . "\n";
} else {
    echo "❌ Admin user not found!\n";
}
?>
