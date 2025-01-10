@extends('license-manager::layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>{{ __('Product Details') }}</h2>
    <a href="{{ route('license-manager.products.index') }}" class="btn btn-secondary">{{ __('Back to Products') }}</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <h5>{{ __('Product Information') }}</h5>
                <p><strong>{{ __('Name:') }}</strong> {{ $product->name }}</p>
                <p><strong>{{ __('Description:') }}</strong> {{ $product->description }}</p>
                <p><strong>{{ __('Price:') }}</strong> {{ $product->price }}</p>
                <p><strong>{{ __('Status:') }}</strong> {{ $product->status }}</p>
            </div>
            <div class="col-md-8">
                <h5>{{ __('Licenses') }}</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('License Key') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Expiry Date') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->licenses as $license)
                        <tr>
                            <td>{{ $license->license_key }}</td>
                            <td>
                                <span class="badge bg-{{ $license->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($license->status) }}
                                </span>
                            </td>
                            <td>{{ $license->end_date ? $license->end_date->format('Y-m-d') : __('Never') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewLicenseModal{{ $license->id }}">
                                    {{ __('View') }}
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- License Details Modal -->
@foreach($product->licenses as $license)
<div class="modal fade" id="viewLicenseModal{{ $license->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('License Details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>{{ __('License Key:') }}</strong> {{ $license->license_key }}</p>
                <p><strong>{{ __('Status:') }}</strong> {{ ucfirst($license->status) }}</p>
                <p><strong>{{ __('Created:') }}</strong> {{ $license->created_at->format('Y-m-d H:i:s') }}</p>
                <p><strong>{{ __('Expires:') }}</strong> {{ $license->end_date ? $license->end_date->format('Y-m-d H:i:s') : __('Never') }}</p>
                <p><strong>{{ __('Last Used:') }}</strong> {{ $license->last_used_at ? $license->last_used_at->format('Y-m-d H:i:s') : __('Never') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
