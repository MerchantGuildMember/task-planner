<x-app-layout>
    <div style="padding: 32px;">
        <h2 style="text-align: center; margin-bottom: 32px;">Edit Task</h2>

        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('PATCH')

            <div style="display: flex; align-items: center; margin-bottom: 24px;">
                <label style="width: 200px;">Title *</label>
                <input type="text" name="title" value="{{ old('title', $task->title) }}"
                    style="flex: 1; border: 1px solid #ccc; padding: 12px;">
                @error('title')
                    <span style="color: red; margin-left: 8px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 24px;">
                <label style="width: 200px;">Description</label>
                <input type="text" name="description" value="{{ old('description', $task->description) }}"
                    style="flex: 1; border: 1px solid #ccc; padding: 12px;">
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 24px;">
                <label style="width: 200px;">Due date</label>
                <input type="date" name="due_date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                    style="border: 1px solid #ccc; padding: 12px; margin-right: 32px;">
                <label style="margin-right: 16px;">Time</label>
                <input type="time" name="due_time" value="{{ old('due_time', $task->due_time) }}"
                    style="border: 1px solid #ccc; padding: 12px;">
            </div>

            <div style="text-align: center; margin-top: 32px; display: flex; justify-content: center; gap: 24px;">
                <button type="submit" style="border: 1px solid #ccc; padding: 12px 48px;">
                    Save Task
                </button>
                <a href="{{ route('tasks.index') }}" style="border: 1px solid #ccc; padding: 12px 48px;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
