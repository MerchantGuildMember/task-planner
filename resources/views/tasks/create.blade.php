<x-app-layout>
    <div style="padding: 32px;">
        <h2 style="text-align: center; margin-bottom: 32px;">Create New Task</h2>

        <form method="POST" action="{{ route('tasks.store') }}" id="createTaskForm">
            @csrf

            <div style="display: flex; align-items: center; margin-bottom: 24px;">
                <label style="width: 200px;">Title *</label>
                <div style="flex: 1;">
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        style="width: 100%; border: 1px solid #ccc; padding: 12px;"
                        required minlength="3" maxlength="255">
                    <span id="titleError" style="color: red; font-size: 12px; display: none;">
                        Title must be at least 3 characters.
                    </span>
                    @error('title')
                        <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 24px;">
                <label style="width: 200px;">Description</label>
                <textarea name="description" id="description" maxlength="1000"
                    style="flex: 1; border: 1px solid #ccc; padding: 12px;">{{ old('description') }}</textarea>
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 24px;">
                <label style="width: 200px;">Due date</label>
                <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
                    min="{{ date('Y-m-d') }}"
                    style="border: 1px solid #ccc; padding: 12px; margin-right: 32px;">
                <span id="dateError" style="color: red; font-size: 12px; display: none;">
                    Date cannot be in the past.
                </span>
                <label style="margin-right: 16px;">Time</label>
                <input type="time" name="due_time" value="{{ old('due_time') }}"
                    style="border: 1px solid #ccc; padding: 12px;">
            </div>

            <div style="text-align: center; margin-top: 32px;">
                <button type="submit" style="border: 1px solid #ccc; padding: 12px 48px;">
                    Save Task
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('createTaskForm').addEventListener('submit', function(e) {
            let valid = true;

            const title = document.getElementById('title').value.trim();
            const titleError = document.getElementById('titleError');
            if (title.length < 3) {
                titleError.style.display = 'block';
                valid = false;
            } else {
                titleError.style.display = 'none';
            }

            const dueDate = document.getElementById('due_date').value;
            const dateError = document.getElementById('dateError');
            if (dueDate) {
                const today = new Date().toISOString().split('T')[0];
                if (dueDate < today) {
                    dateError.style.display = 'block';
                    valid = false;
                } else {
                    dateError.style.display = 'none';
                }
            }

            if (!valid) e.preventDefault();
        });
    </script>
</x-app-layout>