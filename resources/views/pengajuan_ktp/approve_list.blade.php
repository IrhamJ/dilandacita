@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Pengajuan KTP untuk Verifikasi</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendingApplications as $application)
                <tr>
                    <td>{{ $application['formID'] }}</td>
                    <td>{{ $application['fullName'] }}</td>
                    <td>{{ $application['birthPlace'] }}</td>
                    <td>{{ $application['birthDate'] }}</td>
                    <td>{{ $application['applicationState']['status'] }}</td>
                    <td>
                        <a href="{{ route('pengajuan_ktp.show', ['id' => $application['formID']]) }}" class="btn btn-primary">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
