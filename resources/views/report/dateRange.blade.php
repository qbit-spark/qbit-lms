@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Date Range Report</h2>
                </div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('reports') }}">All Reports</a>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <form class="yourform" action="{{ route('reports.date_range_generate') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" required>
                            @error('start_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" required>
                            @error('end_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="submit" class="btn btn-danger" value="Generate">
                    </form>
                </div>
            </div>
            @if(!empty($books))
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="message"></div>
                        <div class="">
                            <div class="">
                                <h4>Report from {{ $start_date }} to {{ $end_date }}</h4>
                            </div>
                            <div class="">
                                <table class="content-table">
                                    <thead>
                                        <th>S.No</th>
                                        <th>Student Name</th>
                                        <th>Book Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Issue Date</th>
                                        <th>Return Date</th>
                                        <th>Status</th>
                                    </thead>
                                    <tbody>
                                    @forelse($books as $book)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $book->student->name }}</td>
                                            <td>{{ $book->book->name }}</td>
                                            <td>{{ $book->student->phone }}</td>
                                            <td>{{ $book->student->email }}</td>
                                            <td>{{ $book->issue_date->format('d M, Y') }}</td>
                                            <td>{{ $book->return_date ? $book->return_date->format('d M, Y') : 'Not Returned' }}</td>
                                            <td>
                                                @if($book->issue_status == 'Y')
                                                    <span class='badge badge-success'>Returned</span>
                                                @else
                                                    <span class='badge badge-danger'>Issued</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">No Books Issued</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection