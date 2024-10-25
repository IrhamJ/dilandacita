<?php

namespace App\Http\Controllers;

use App\Models\PengajuanCetakKtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PengajuanKtpController extends Controller
{
    // Display the form
    public function create()
    {
        return view('pengajuan_ktp.create');
    }

    // Handle form submission
    public function store(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|max:255',
            'birthPlace' => 'required|string|max:255',
            'birthDate' => 'required|date',
            'gender' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'rtRw' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'subdistrict' => 'required|string|max:255',
            'religion' => 'required|string|max:255',
            'maritalStatus' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'citizenship' => 'required|string|max:255',
            'bloodType' => 'required|string|max:255',
            
        ]);

        // Insert into database
        $pengajuan = PengajuanCetakKtp::create(array_merge($request->all(), [
            'submittedBy' => auth()->user()->id, // Mengambil ID user yang sedang login
        ]));

        // Lakukan request POST untuk mendapatkan token dari API
        $tokenResponse = Http::post('http://212.38.94.235:8801/user/enroll', [
            'id' => 'admin',          // ID user
            'secret' => 'adminpw',    // Secret untuk user
        ]);

        // Cek apakah token berhasil didapatkan
        if ($tokenResponse->successful()) {
            $tokenData = $tokenResponse->json();

            // Ambil token dari response
            $token = $tokenData['token'];  // Pastikan nama kunci ini sesuai dengan response API

            // Kirim data ke API Postman menggunakan token yang baru didapatkan
            $data = [
                'method' => 'submitApplication',
                'args' => [
                    (string)$pengajuan->id,               // formID
                    (string)$pengajuan->fullName,         // fullName
                    (string)$pengajuan->birthPlace,       // birthPlace
                    (string)$pengajuan->birthDate,        // birthDate (diubah ke string)
                    (string)$pengajuan->gender,           // gender
                    (string)$pengajuan->address,          // address
                    (string)$pengajuan->rtRw,             // rtRw
                    (string)$pengajuan->village,          // village
                    (string)$pengajuan->subdistrict,      // subdistrict
                    (string)$pengajuan->religion,         // religion
                    (string)$pengajuan->maritalStatus,    // maritalStatus
                    (string)$pengajuan->occupation,       // occupation
                    (string)$pengajuan->citizenship,      // citizenship
                    (string)$pengajuan->bloodType,        // bloodType
                    (string)auth()->user()->id,      // submittedBy
                ],
            ];

            // Kirim data ke API dengan token yang baru didapatkan
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->timeout(60)->post('http://212.38.94.235:8801/invoke/my-channel1/ktp-chaincode', $data);
            
            // Cek response dari API
            if ($response->successful()) {
                // Tampilkan response jika berhasil
                dd($response->json());
            } else {
                // Tampilkan pesan error jika gagal
                dd($response->body());
            }
        } else {
            // Tampilkan pesan error jika gagal mendapatkan token
            dd($tokenResponse->body());
        }

        return redirect()->route('pengajuan_ktp.create')->with('success', 'KTP application submitted successfully.');
    }
}
