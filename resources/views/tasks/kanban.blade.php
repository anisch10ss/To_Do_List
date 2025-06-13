@extends('layouts.app')

@section('styles')
<style>
    .kanban-column {
        min-height: 300px;
        border-radius: 0.25rem;
    }
    .task-card {
        margin-bottom: 1rem;
        cursor: pointer;
    }
    .todo-column {
        background-color: #fff8e1;
    }
    .progress-column {
        background-color: #e3f2fd;
    }
    .done-column {
        background-color: #e8f5e9;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2>Kanban Board</h2>
                    </div>
                    <div>
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-primary me-2">List View</a>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Add Task</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <!-- To Do Column -->
                        <div class="col-md-4">
                            <div class="card todo-column">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="mb-0">To Do ({{ $todoTasks->count() }})</h5>
                                </div>
                                <div class="card-body">
                                    @forelse ($todoTasks as $task)
                                        <div class="card task-card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $task->title }}</h5>
                                                <p class="card-text">{{ Str::limit($task->description, 100) }}</p>
                                                @if ($task->due_date)
                                                    <p class="card-text"><small class="text-muted">Due: {{ $task->due_date->format('Y-m-d') }}</small></p>
                                                @endif
                                                <div class="d-flex justify-content-end">
                                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-primary me-1">Edit</a>
                                                    <form action="{{ route('tasks.complete', $task) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">Complete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-center">No tasks in this column.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- In Progress Column -->
                        <div class="col-md-4">
                            <div class="card progress-column">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">In Progress ({{ $inProgressTasks->count() }})</h5>
                                </div>
                                <div class="card-body">
                                    @forelse ($inProgressTasks as $task)
                                        <div class="card task-card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $task->title }}</h5>
                                                <p class="card-text">{{ Str::limit($task->description, 100) }}</p>
                                                @if ($task->due_date)
                                                    <p class="card-text"><small class="text-muted">Due: {{ $task->due_date->format('Y-m-d') }}</small></p>
                                                @endif
                                                <div class="d-flex justify-content-end">
                                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-primary me-1">Edit</a>
                                                    <form action="{{ route('tasks.complete', $task) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">Complete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-center">No tasks in this column.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Done Column -->
                        <div class="col-md-4">
                            <div class="card done-column">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Done ({{ $doneTasks->count() }})</h5>
                                </div>
                                <div class="card-body">
                                    @forelse ($doneTasks as $task)
                                        <div class="card task-card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $task->title }}</h5>
                                                <p class="card-text">{{ Str::limit($task->description, 100) }}</p>
                                                @if ($task->due_date)
                                                    <p class="card-text"><small class="text-muted">Completed: {{ $task->updated_at->format('Y-m-d') }}</small></p>
                                                @endif
                                                <div class="d-flex justify-content-end">
                                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-center">No tasks in this column.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
