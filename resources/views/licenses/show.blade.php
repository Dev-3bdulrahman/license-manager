@extends('license-manager::layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ __('License Details') }}</h2>
        <a href="{{ route('license-manager.licenses.index') }}" class="btn btn-secondary">{{ __('Back to Licenses') }}</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>{{ __('License Information') }}</h5>
                    <p><strong>{{ __('License Key:') }}</strong> {{ $license->license_key }}</p>
                    <p><strong>{{ __('Status:') }}</strong>
                        <span class="badge bg-{{ $license->status === 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($license->status) }}
                        </span>
                    </p>
                    <p><strong>{{ __('Type:') }}</strong> {{ ucfirst($license->type) }}</p>
                    <p><strong>{{ __('Created:') }}</strong> {{ $license->created_at->format('Y-m-d H:i:s') }}</p>
                    <p><strong>{{ __('Expires:') }}</strong>
                        {{ $license->end_date ? $license->end_date->format('Y-m-d H:i:s') : __('Never') }}</p>
                    <p><strong>{{ __('Last Used:') }}</strong>
                        {{ $license->last_used_at ? $license->last_used_at->format('Y-m-d H:i:s') : __('Never') }}</p>
                </div>
                <div class="col-md-6">
                    <h5>{{ __('Customer Information') }}</h5>
                    <p><strong>{{ __('Name:') }}</strong> {{ $license->customer->name }}</p>
                    <p><strong>{{ __('Email:') }}</strong> {{ $license->customer->email }}</p>
                    <p><strong>{{ __('Phone:') }}</strong> {{ $license->customer->phone }}</p>

                    <h5 class="mt-4">{{ __('Product Information') }}</h5>
                    <p><strong>{{ __('Product:') }}</strong> {{ $license->product->name }}</p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h5>{{ __('Registered Domains') }}</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Domain') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Last Verified') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($license->domains as $domain)
                                <tr>
                                    <td>{{ $domain->domain }}</td>
                                    <td>
                                        <span class="badge bg-{{ $domain->status === 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($domain->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $domain->last_verified_at ? $domain->last_verified_at->format('Y-m-d H:i:s') : __('Never') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex gap-2">
                        @if ($license->status === 'active')
                            <form action="{{ route('license-manager.licenses.suspend', $license) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning">{{ __('Suspend License') }}</button>
                            </form>
                        @else
                            <form action="{{ route('license-manager.licenses.reactivate', $license) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">{{ __('Reactivate License') }}</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
