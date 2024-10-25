@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Welcome to the Dashboard</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mt-4">
        <a href="{{ route('pengajuan_ktp.create') }}" class="btn btn-primary">Create Pengajuan KTP</a>
        <a href="{{ route('pengajuan_ktp.approveList') }}" class="btn btn-secondary">Approve Pengajuan KTP</a>
        
    </div>
</div>
@endsection
