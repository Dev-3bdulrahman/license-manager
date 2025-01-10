<?php
@extends('license-manager::layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Customers</h5>
                <p class="card-text display-4">{{ $totalCustomers }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Active Licenses</h5>
                <p class="card-text display-4">{{ $activeLicenses }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Expiring Soon</h5>
                <p class="card-text display-4">{{ $expiringSoon }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Recent Licenses
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>License Key</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Expiry</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentLicenses as $license)
                        <tr>
                            <td>{{ $license->customer->name }}</td>
                            <td>{{ $license->license_key }}</td>
                            <td>{{ ucfirst($license->type) }}</td>
                            <td>
                                <span class="badge bg-{{ $license->status === 'active' ? 'success' : ($license->status === 'expired' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($license->status) }}
                                </span>
                            </td>
                            <td>{{ $license->end_date->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection