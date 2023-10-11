@extends('layout')  <!-- Extend your layout file -->

@section('content')
<div class="container">
@if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

              
    @if(session('error'))
            <div id="error-message" class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Level</th>
                <th>Status</th>
                <th>Action</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($leaveApplications as $leaveApplication)
                <tr>
                    <td>{{ $leaveApplication->user->name }}</td>
                    <td>{{ $leaveApplication->start_date }}</td>
                    <td>{{ $leaveApplication->end_date }}</td>
                    <td>{{ $leaveApplication->level1 }}</td>
                    <td>{{ $leaveApplication->status }}</td>
                    <td>
                        <a type="button"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#acceptleave{{ $leaveApplication->id}}">Accept</a>
                        <a href="" class="btn btn-primary btn-sm">View</a> 
                        </td>
                <div class="modal" id="acceptleave{{ $leaveApplication->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <span class="modal-title">Leave Approval</span>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                    
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form method="POST" action="{{ route('leave.approve', ['id' => $leaveApplication->id]) }}">
                                @csrf
                            <h4>Are you sure you want to approve this leave?</h4>

                        <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Approve Now</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>

                        
                    <!-- Add more columns as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
