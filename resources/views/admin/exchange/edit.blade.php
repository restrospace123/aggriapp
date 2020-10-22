@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Edit Income Or Expences') }}
                    &nbsp;&nbsp;
                    <a href="dashboard">Go Back</a>
                </div>

                <div class="card-body">


                    <div class="card-body">
                        @if (session('exchange-status'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ session('exchange-status') }}</strong>
                        </div>
                        @endif

                    </div>

                    <form method="POST" action="{{ route('exchange.update') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>
                            <input type="hidden" name="id" value="{{$fields->id}}">
                            <div class="col-md-6">
                                <select class="form-control @error('type') is-invalid @enderror" name="type">
                                    <option value="">Type</option>
                                    <option @if($fields->type_id == 1) selected @endif value="1">Income</option>
                                    <option @if($fields->type_id == 2) selected @endif value="2">Expense</option>
                                </select>

                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}</label>

                            <div class="col-md-6">
                                <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ $fields->amount }}" required autocomplete="amount">

                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" required autocomplete="description">{{$fields->description}}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ondate" class="col-md-4 col-form-label text-md-right">{{ __('On Date') }}</label>

                            <div class="col-md-6">
                                <input id="ondate" type="date" class="form-control" name="ondate" value="{{$fields->ondate}}" required autocomplete="ondate">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection