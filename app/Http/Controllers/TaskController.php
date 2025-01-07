<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve query parameters for search and filter
        $search = $request->input('search');
        $status = $request->status;

        // Query the tasks with optional search and filter
        $tasks = Task::query()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                             ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->paginate(10); // Pagination with 10 items per page

        return view('task.index', compact('tasks', 'search', 'status'));
    }

    public function create()
    {
        return view('task.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'required|date|after:today',
        ]);

        $validated['user_id'] = Auth::id();

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function edit(Task $task)
    {
        return view('task.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}
