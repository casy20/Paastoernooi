@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h1 class="mb-4">Management Pagina</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <p class="mb-4">
        <a href="{{ route('manuals.index') }}" class="btn btn-secondary">
            Bekijk opgeslagen Teams
        </a>
    </p>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('manuals.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Merk</label>
                    <select name="brand_id" class="form-select" required>
                        <option value="">-- kies merk --</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type_id" class="form-select" required>
                        <option value="">-- kies type --</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('type_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Naam Team</label>
                    <input type="text" name="name" class="form-control" required>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">URL</label>
                    <input type="url" name="originUrl" class="form-control">
                    @error('originUrl')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary">Opslaan</button>
            </form>

        </div>
    </div>
</div>
@endsection
