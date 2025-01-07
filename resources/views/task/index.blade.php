@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Header Section with Logout, Edit Profile, and Create Task -->
    <div class="d-flex justify-content-between mb-4">
        <h1>Tasks</h1>
        <div>
            <!-- Logout Button using a POST form -->
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
            </form>

            <!-- Edit Profile Button (example) -->
            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">Edit Profile</a>

            <!-- Create Task Button -->
            <a href="{{ route('tasks.create') }}" class="btn btn-success btn-sm">Create Task</a>
        </div>
    </div>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('tasks.index') }}" class="mb-4">
        <div class="row g-3">
            <!-- Search Bar -->
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Search tasks..." value="{{ request('search') }}">
            </div>
            <!-- Status Filter -->
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <!-- Submit Button -->
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </div>
    </form>

    <!-- Tasks Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ ucfirst($task->status) }}</td>
                    <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'N/A' }}</td>
                    <td>
                        <!-- Edit and Delete buttons -->
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
</form>

<script>
    function confirmDelete() {
        // Display a confirmation dialog box
        return confirm("Are you sure you want to delete this task?");
    }
</script>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No tasks found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $tasks->links() }}
</div>
@endsection
