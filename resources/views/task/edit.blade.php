@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update Task</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('task.update', $task->id) }}">
                        @csrf
                        
                        @method('PUT')

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="started" {{ $task->status == 'started' ? 'selected' : '' }}>Started</option>
                                <option value="paused" {{ $task->status == 'paused' ? 'selected' : '' }}>Paused</option>
                                <option value="finished" {{ $task->status == 'finished' ? 'selected' : '' }}>Finished</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
