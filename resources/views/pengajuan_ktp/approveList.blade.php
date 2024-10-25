<!-- resources/views/pengajuan_ktp/approve_list.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Approve Applications</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($applications as $application)
            <tr>
                <td>{{ $application->id }}</td>
                <td>{{ $application->fullName }}</td>
                <td>{{ $application->status }}</td>
                <td>
                <form action="{{ route('pengajuan_ktp.show', $application->id) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
