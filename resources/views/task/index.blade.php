@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Task List</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($tasks->isEmpty())
                        <p>No tasks available.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Responsible</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Duration</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td>{{ $task->name }}</td>
                                        <td>{{ $task->description }}</td>
                                        <td>{{ $task->responsible }}</td>
                                        <td>{{ $task->category }}</td>
                                        <td>{{ $task->status }}</td>
                                        <td>{{ $task->start_date }}</td>
                                        <td>{{ $task->end_date ?? 'Not Finished' }}</td>
                                        <td>
                                            @if ($task->start_date && $task->end_date)
                                                {{ \Carbon\Carbon::parse($task->start_date)->diffForHumans(\Carbon\Carbon::parse($task->end_date), true) }}
                                            @else
                                                {{ 'N/A' }}
                                            @endif
                                        </td>                                        
                                        <td>
                                            <a href="{{ route('task.edit', $task->id) }}" class="btn btn-sm btn-primary">E</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
