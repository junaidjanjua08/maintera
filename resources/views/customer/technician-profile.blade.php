@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Technician Profile</h2>
    <div class="card">
        <div class="card-body">
            <h4>{{ $technician->name }}</h4>
            <p><strong>Email:</strong> {{ $technician->email }}</p>
            <p><strong>Phone:</strong> {{ $technician->technicianProfile->phone ?? 'N/A' }}</p>
            <p><strong>Occupation:</strong> {{ $technician->technicianProfile->occupation ?? 'N/A' }}</p>
            <p><strong>Experience:</strong> {{ $technician->technicianProfile->experience ?? 'N/A' }}</p>
            <p><strong>Qualification:</strong> {{ $technician->technicianProfile->qualification ?? 'N/A' }}</p>
            <p><strong>Bio:</strong> {{ $technician->technicianProfile->bio ?? 'N/A' }}</p>
            <p><strong>Rating:</strong> {{ $technician->technicianProfile->rating ?? 'N/A' }}</p>
        </div>
    </div>
    <a href="javascript:history.back()" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection 