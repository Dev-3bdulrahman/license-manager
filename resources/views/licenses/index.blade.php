@extends('license-manager::layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>{{ __('Licenses') }}</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLicenseModal">
        {{ __('Create License') }}
    </button>
</div>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Customer') }}</th>
                    <th>{{ __('License Key') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Domains') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Expiry') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($licenses as $license)
                <tr>
                    <td>{{ $license->customer->name }}</td>
                    <td>{{ $license->license_key }}</td>
                    <td>{{ ucfirst($license->type) }}</td>
                    <td>
                        @foreach($license->domains as $domain)
                            <span class="badge bg-secondary">{{ $domain->domain }}</span>
                        @endforeach
                    </td>
                    <td>
                        <span class="badge bg-{{ $license->status === 'active' ? 'success' : ($license->status === 'expired' ? 'danger' : 'warning') }}">
                            {{ ucfirst($license->status) }}
                        </span>
                    </td>
                    <td>{{ $license->end_date->format('Y-m-d') }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewLicenseModal{{ $license->id }}">
                                {{ __('View') }}
                            </button>
                            @if($license->status === 'active')
                            <form action="{{ route('license-manager.licenses.suspend', $license) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('{{ __('Are you sure you want to suspend this license?') }}')">
                                    {{ __('Suspend') }}
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Create License Modal -->
<div class="modal fade" id="addLicenseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('license-manager.licenses.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Create License') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Customer') }}</label>
                        <select class="form-select" name="customer_id" required>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('License Type') }}</label>
                        <select class="form-select" name="type" required>
                            <option value="single">{{ __('Single Domain') }}</option>
                            <option value="multiple">{{ __('Multiple Domains') }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Domains') }}</label>
                        <input type="text" class="form-control" name="domains" required placeholder="{{ __('Enter domains separated by commas') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('End Date') }}</label>
                        <input type="date" class="form-control" name="end_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Create License') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection