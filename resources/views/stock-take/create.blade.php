@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">New Stock Take</h2>
                </div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('stock-take.index') }}">All Stock Takes</a>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <form class="yourform" action="{{ route('stock-take.store') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label>Stock Take Date</label>
                            <input type="date" class="form-control @error('stock_take_date') is-invalid @enderror"
                                name="stock_take_date" value="{{ old('stock_take_date', date('Y-m-d')) }}" required>
                            @error('stock_take_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="submit" name="submit" class="btn btn-danger" value="Start Stock Take">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection