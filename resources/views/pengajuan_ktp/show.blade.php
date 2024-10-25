@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Pengajuan KTP</h1>

    <p><strong>ID Form:</strong> {{ $formID }}</p>
    <p><strong>Application Data:</strong></p>
    <pre>{{ json_encode($application, JSON_PRETTY_PRINT) }}</pre>

    <form action="{{ route('pengajuan_ktp.verify', ['id' => $formID]) }}" method="POST">
        @csrf
        <input type="hidden" name="method" value="verifyApplication">
        <input type="hidden" name="args[]" value="{{ $formID }}">
        <input type="hidden" name="args[]" value="modifier1">

        <button type="submit" class="btn btn-primary">Verify</button>
    </form>

    <form action="{{ route('pengajuan_ktp.approve', ['id' => $formID]) }}" method="POST" style="margin-top: 20px;">
        @csrf
        <input type="hidden" name="approvedBy" value="{{ auth()->user()->id }}">

        <button type="submit" class="btn btn-success">Approve</button>
    </form>

    <form action="{{ route('pengajuan_ktp.issue', ['id' => $formID]) }}" method="POST" style="margin-top: 20px;">
        @csrf
        <input type="hidden" name="nik" value="3273221010020002"> <!-- Fixed NIK -->
        <input type="hidden" name="issuedBy" value="{{ auth()->user()->id }}"> <!-- ID user yang melakukan issue -->

        <button type="submit" class="btn btn-warning">Issue KTP</button>
    </form>
</div>
@endsection
