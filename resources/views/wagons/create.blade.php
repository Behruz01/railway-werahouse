@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Wagon') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('wagons.store') }}">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="train_id" class="col-md-4 col-form-label text-md-right">{{ __('Train') }}</label>

                            <div class="col-md-6">
                                <select id="train_id" class="form-control @error('train_id') is-invalid @enderror" name="train_id" required>
                                    <option value="">Select Train</option>
                                    @foreach($trains as $train)
                                        <option value="{{ $train->id }}" {{ old('train_id') == $train->id ? 'selected' : '' }}>
                                            {{ $train->name }} ({{ $train->registration_number }})
                                        </option>
                                    @endforeach
                                </select>

                                @error('train_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="wagon_number" class="col-md-4 col-form-label text-md-right">{{ __('Wagon Number') }}</label>

                            <div class="col-md-6">
                                <input id="wagon_number" type="text" class="form-control @error('wagon_number') is-invalid @enderror" name="wagon_number" value="{{ old('wagon_number') }}" required>

                                @error('wagon_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="capacity" class="col-md-4 col-form-label text-md-right">{{ __('Capacity') }}</label>

                            <div class="col-md-6">
                                <input id="capacity" type="number" class="form-control @error('capacity') is-invalid @enderror" name="capacity" value="{{ old('capacity') }}" required min="1">

                                @error('capacity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                            <div class="col-md-6">
                                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>

                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>
                                <a href="{{ route('wagons.index') }}" class="btn btn-secondary">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
