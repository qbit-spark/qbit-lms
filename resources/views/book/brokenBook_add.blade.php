@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Add Damaged Book</h2>
                </div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('broken-book') }}">All Damaged Book List</a>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <form class="yourform" action="{{ route('broken-book.create') }}" method="post" autocomplete="off">
                        @csrf

                        <!-- Book Selection -->
                        <div class="form-group">
                            <label>Book Name</label>
                            <select class="form-control" name="book_id" required>
                                <option value="">Select Book</option>
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                        {{ $book->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('book_id')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Damage Type -->
                        <div class="form-group mt-3">
                            <label>Damage Type</label>
                            <select class="form-control" name="damage_type_id" required>
                                <option value="">Select Type</option>
                                @foreach ($damageTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('damage_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('damage_type_id')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Collection Deducts -->
                        <div class="row">
                            <div class="form-group mt-3 col-md-6">
                                <label>Damage Status</label>
                                <select class="form-control" name="deduct_status" required>
                                    <option value="">Select Type</option>
                                    @foreach ([(object) ['id' => 'deducted', 'name' => 'Deducted from Stock'], (object) ['id' => 'not_deducted', 'name' => 'Not Deducted from Stock']] as $type)
                                        <option value="{{ $type->id }}"
                                            {{ old('deduct_status') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('deduct_status')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Damaged Quantity -->
                            <div class="form-group mt-3 col-md-6">
                                <label>Damaged Quantity</label>
                                <input type="number" class="form-control" name="damaged_quantity" min="1"
                                    value="{{ old('damaged_quantity', 1) }}" required>
                                @error('damaged_quantity')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group mt-3">
                            <label>Description</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Describe the damage...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Damage Date -->
                        <div class="form-group mt-3">
                                <label>Damage Date</label>
                                <input type="date" class="form-control" name="damage_date"
                                    value="{{ old('damage_date', date('Y-m-d')) }}" required>
                                @error('damage_date')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        <!-- Repair Cost -->
                        <div class="form-group mt-3">
                            <label>Repair Cost (optional)</label>
                            <input type="number" step="0.01" class="form-control" name="repair_cost"
                                value="{{ old('repair_cost', 0.0) }}">
                            @error('repair_cost')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remarks -->
                        <div class="form-group mt-3">
                            <label>Remarks</label>
                            <textarea class="form-control" name="remarks" rows="2" placeholder="Additional comments...">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="submit" name="save" class="btn btn-danger" value="save">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
