@extends('layouts.app')

@section('content')
    <h1>Verifikasi Aplikasi KTP</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h3>Detail Aplikasi</h3>
    <ul>
        <li>Full Name: {{ $application['fullName'] }}</li>
        <li>Birth Place: {{ $application['birthPlace'] }}</li>
        <li>Birth Date: {{ $application['birthDate'] }}</li>
        <li>Gender: {{ $application['gender'] }}</li>
        <!-- Tampilkan detail lainnya sesuai dengan respons dari API -->
    </ul><!-- resources/views/pengajuan_ktp/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Pengajuan KTP</h1>

    <p><strong>ID Form:</strong> {{ $formID }}</p>
    <p><strong>Application Data:</strong></p>
    <pre>{{ json_encode($application, JSON_PRETTY_PRINT) }}</pre>

    <a href="{{ route('pengajuan_ktp.approve', ['id' => $formID]) }}" class="btn btn-primary">Approve</a>
</div>
@endsection


    <form action="{{ route('pengajuan_ktp.approve', ['id' => $formID]) }}" method="POST">
        @csrf
        <input type="hidden" name="approvedBy" value="{{ auth()->user()->id }}">
        <button type="submit" class="btn btn-primary">Verify</button>
    </form>
@endsection
