@extends('license-manager::layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>{{ __('Products') }}</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
        {{ __('Add Product') }}
    </button>
</div>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Description') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->status }}</td>
                    <td>
                        <a href="{{ route('license-manager.products.show', $product) }}" class="btn btn-sm btn-info">{{ __('View') }}</a>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $product->id }}">
                            {{ __('Edit') }}
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('license-manager.products.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add Product') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Description') }}</label>
                        <textarea class="form-control" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Price') }}</label>
                        <input type="number" step="0.01" class="form-control" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Image URL') }}</label>
                        <input type="text" class="form-control" name="image">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Status') }}</label>
                        <select class="form-control" name="status" required>
                            <option value="active">{{ __('Active') }}</option>
                            <option value="inactive">{{ __('Inactive') }}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Add Product') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
@foreach($products as $product)
<div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('license-manager.products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Edit Product') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Description') }}</label>
                        <textarea class="form-control" name="description" required>{{ $product->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Price') }}</label>
                        <input type="number" step="0.01" class="form-control" name="price" value="{{ $product->price }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Image URL') }}</label>
                        <input type="text" class="form-control" name="image" value="{{ $product->image }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Status') }}</label>
                        <select class="form-control" name="status" required>
                            <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Update Product') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
