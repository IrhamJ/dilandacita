<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PengajuanCetakKtp;


class ApproveKTPController extends Controller
{
    // Method untuk menampilkan halaman verifikasi
    public function approveList()
{
    // dd('approveList'); // Hapus atau komentari baris ini

    // Lakukan request POST untuk mendapatkan token dari API
    $tokenResponse = Http::post('http://212.38.94.235:8801/user/enroll', [
        'id' => 'admin',          // ID user
        'secret' => 'adminpw',    // Secret untuk user
    ]); 

    if ($tokenResponse->successful()) {
        $tokenData = $tokenResponse->json();
        $token = $tokenData['token'];

        // Kirim request ke API untuk mendapatkan data semua aplikasi KTP
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post('http://212.38.94.235:8801/query/my-channel1/ktp-chaincode', [
            'method' => 'queryApplication',  // Sesuaikan dengan API untuk mendapatkan semua aplikasi
        ]);

        if ($response->successful()) {
            $applications = $response->json()['response']['applications'];

            // Filter aplikasi dengan status 'pending'
            $pendingApplications = array_filter($applications, function($application) {
                return $application['applicationState']['status'] == 'Pending';
            });

            return view('pengajuan_ktp.approve_list', compact('pendingApplications'));
        } else {
            return back()->withErrors(['message' => 'Failed to retrieve applications from API.']);
        }
    } else {
        return back()->withErrors(['message' => 'Failed to get token from API.']);
    }

    // dd('approveList'); // Hapus atau komentari baris ini juga
}
    public function show($id)
    {
        
        // Lakukan request POST untuk mendapatkan token dari API
        $tokenResponse = Http::post('http://212.38.94.235:8801/user/enroll', [
            'id' => 'admin',          // ID user
            'secret' => 'adminpw',    // Secret untuk user
        ]);

        // Cek apakah token berhasil didapatkan
        if ($tokenResponse->successful()) {
            $tokenData = $tokenResponse->json();
            $token = $tokenData['token'];

            // Kirim request ke API untuk mendapatkan data aplikasi KTP
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post('http://212.38.94.235:8801/query/my-channel1/ktp-chaincode', [
                'method' => 'queryApplication',
                'args' => [
                    (string)$id,  // formID
                ]
            ]);

            // Cek apakah data berhasil diambil
            if ($response->successful()) {
                $applicationData = $response->json();

                // Kembalikan data ke view untuk ditampilkan
                return view('pengajuan_ktp.show', [
                    'application' => $applicationData,
                    'formID' => $id,
                ]);
            } else {
                return back()->withErrors(['message' => 'Failed to retrieve application data.']);
            }
        } else {
            return back()->withErrors(['message' => 'Failed to get token from API.']);
        }
    }

    // Method untuk melakukan verifikasi dan approve
    public function approve(Request $request, $id)
{
    $request->validate([
        'approvedBy' => 'required|string|max:255',  // Validasi ID user yang melakukan approve
    ]);

    // Lakukan request POST untuk mendapatkan token dari API
    $tokenResponse = Http::post('http://212.38.94.235:8801/user/enroll', [
        'id' => 'admin',          // ID user
        'secret' => 'adminpw',    // Secret untuk user
    ]);

    // Cek apakah token berhasil didapatkan
    if ($tokenResponse->successful()) {
        $tokenData = $tokenResponse->json();
        $token = $tokenData['token'];

        // Kirim request untuk approve application ke API
        $approveResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post('http://212.38.94.235:8801/invoke/my-channel1/ktp-chaincode', [
            'method' => 'approveApplication',
            'args' => [
                (string)$id,             // formID
                (string)$request->approvedBy, // approvedBy (ID user yang sedang login)
            ]
        ]);

        // Cek apakah proses approve berhasil
        if ($approveResponse->successful()) {
            return redirect()->route('pengajuan_ktp.show', ['id' => $id])
                ->with('success', 'Application approved successfully.');
        } else {
            return back()->withErrors(['message' => 'Failed to approve application.']);
        }
    } else {
        return back()->withErrors(['message' => 'Failed to get token from API.']);
    }
}

    

    public function verify(Request $request, $id)
{
    // Validasi bahwa 'approvedBy' ada di request
    $request->validate([
        'approvedBy' => $id,  // Validasi ID user yang melakukan verifikasi
    ]);

    // Lakukan request POST untuk mendapatkan token dari API
    $tokenResponse = Http::post('http://212.38.94.235:8801/user/enroll', [
        'id' => 'admin',          // ID user
        'secret' => 'adminpw',    // Secret untuk user
    ]);

    // Cek apakah token berhasil didapatkan
    if ($tokenResponse->successful()) {
        $tokenData = $tokenResponse->json();
        $token = $tokenData['token'];

        // Kirim request untuk verifikasi ke API
        $verifyResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post('http://212.38.94.235:8801/invoke/my-channel1/ktp-chaincode', [
            'method' => 'verifyApplication',
            'args' => [
                (string)$id,             // formID
                (string)auth()->user()->id, // approvedBy (ID user yang sedang login)
            ]
        ]);

        // Cek apakah proses verifikasi berhasil
        if ($verifyResponse->successful()) {
            return redirect()->route('pengajuan_ktp.show', ['id' => $id])
                ->with('success', 'Application verified successfully.');
        } else {
            // Dapatkan pesan kesalahan dari respons jika ada
            $errorMessage = $verifyResponse->json()['error'] ?? 'Failed to verify application.';
            return back()->withErrors(['message' => $errorMessage]);
        }
    } else {
        // Dapatkan pesan kesalahan dari respons jika ada
        $errorMessage = $tokenResponse->json()['error'] ?? 'Failed to get token from API.';
        return back()->withErrors(['message' => $errorMessage]);
    }
}
public function issue(Request $request, $id)
{
    // Validasi input yang diperlukan
    $request->validate([
        'issuedBy' => 'required|string|max:255', // Validasi ID user yang melakukan issue
    ]);

    // Lakukan request POST untuk mendapatkan token dari API
    $tokenResponse = Http::post('http://212.38.94.235:8801/user/enroll', [
        'id' => 'admin',          // ID user
        'secret' => 'adminpw',    // Secret untuk user
    ]);

    // Cek apakah token berhasil didapatkan
    if ($tokenResponse->successful()) {
        $tokenData = $tokenResponse->json();
        $token = $tokenData['token'];

        // NIK generik
        $nik = "3273221010020002";

        // Kirim request untuk issue KTP ke API
        $issueResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post('http://212.38.94.235:8801/invoke/my-channel1/ktp-chaincode', [
            'method' => 'issueKTP',
            'args' => [
                (string)$id,            // formID
                $nik,                   // NIK generik
                (string)$request->issuedBy, // issuedBy (ID user yang sedang login)
            ]
        ]);

        // Cek apakah proses issue berhasil
        if ($issueResponse->successful()) {
            return redirect()->route('pengajuan_ktp.show', ['id' => $id])
                ->with('success', 'KTP issued successfully.');
        } else {
            return back()->withErrors(['message' => 'Failed to issue KTP.']);
        }
    } else {
        return back()->withErrors(['message' => 'Failed to get token from API.']);
    }
}



}
