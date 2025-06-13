<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Auth::user()->tasks;
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Display the kanban board view.
     */
    public function kanban()
    {
        $todoTasks = Auth::user()->tasks()->where('status', 'todo')->get();
        $inProgressTasks = Auth::user()->tasks()->where('status', 'in-progress')->get();
        $doneTasks = Auth::user()->tasks()->where('status', 'done')->get();
        
        return view('tasks.kanban', compact('todoTasks', 'inProgressTasks', 'doneTasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|string|in:todo,in-progress,done',
        ]);

        $task = new Task($validated);
        $task->user_id = Auth::id();
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|string|in:todo,in-progress,done',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Mark a task as completed.
     */
    public function markCompleted(Task $task)
    {
        $this->authorize('update', $task);
        
        $task->completed = true;
        $task->status = 'done';
        $task->save();

        return redirect()->back()->with('success', 'Task marked as completed.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    /**
     * Export tasks to different formats.
     */
    public function export(Request $request)
    {
        $format = $request->format ?? 'csv';
        $tasks = Auth::user()->tasks;

        switch ($format) {
            case 'excel':
                return $this->exportToExcel($tasks);
            case 'pdf':
                return $this->exportToPdf($tasks);
            case 'csv':
            default:
                return $this->exportToCsv($tasks);
        }
    }

    /**
     * Export tasks to CSV.
     */
    private function exportToCsv($tasks)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="tasks.csv"',
        ];

        $callback = function() use ($tasks) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Title', 'Description', 'Due Date', 'Status', 'Completed']);

            foreach ($tasks as $task) {
                fputcsv($file, [
                    $task->id,
                    $task->title,
                    $task->description,
                    $task->due_date,
                    $task->status,
                    $task->completed ? 'Yes' : 'No',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export tasks to Excel.
     * Note: This would require the maatwebsite/excel package in a real application.
     */
    private function exportToExcel($tasks)
    {
        // Implementation would use Laravel Excel package
        return redirect()->back()->with('info', 'Excel export would be implemented here.');
    }

    /**
     * Export tasks to PDF.
     * Note: This would require a PDF package like dompdf in a real application.
     */
    private function exportToPdf($tasks)
    {
        // Implementation would use a PDF package
        return redirect()->back()->with('info', 'PDF export would be implemented here.');
    }
}
