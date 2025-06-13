@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2>Tasks</h2>
                    </div>
                    <div>
                        <a href="{{ route('tasks.kanban') }}" class="btn btn-outline-primary me-2">Kanban View</a>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Add Task</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tasks as $task)
                                    <tr class="{{ $task->completed ? 'table-success' : '' }}">
                                        <td>{{ $task->title }}</td>
                                        <td>{{ Str::limit($task->description, 50) }}</td>
                                        <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'N/A' }}</td>
                                        <td>
                                            @if ($task->status === 'todo')
                                                <span class="badge bg-warning">To Do</span>
                                            @elseif ($task->status === 'in-progress')
                                                <span class="badge bg-info">In Progress</span>
                                            @else
                                                <span class="badge bg-success">Done</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                @if (!$task->completed)
                                                    <form action="{{ route('tasks.complete', $task) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success me-1">Complete</button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-primary me-1">Edit</a>
                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No tasks found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Export Tasks
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="{{ route('tasks.export', ['format' => 'csv']) }}">CSV</a></li>
                                <li><a class="dropdown-item" href="{{ route('tasks.export', ['format' => 'excel']) }}">Excel</a></li>
                                <li><a class="dropdown-item" href="{{ route('tasks.export', ['format' => 'pdf']) }}">PDF</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
