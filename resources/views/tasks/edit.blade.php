<x-layouts.app :title="__('Task編集')">
  <div class="p-6">
    <a href="{{ route('tasks.show', $task) }}" class="text-blue-500 hover:text-blue-700">詳細に戻る</a>
    <form method="POST" action="{{ route('tasks.update', $task) }}" class="mt-4">
      @csrf
      @method('PUT')
      <div class="mb-4">
        <label for="taks" class="block text-sm font-bold mb-2">Edit Task</label>
        <input type="text" name="task" id="task" value="{{ $task->task }}" class="border rounded w-full py-2 px-3 dark:bg-gray-700">
        @error('task')
        <span class="text-red-500 text-xs italic">{{ $message }}</span>
        @enderror
      </div>
      <div class="mb-4">
        <label for="scheduled_at" class="block text-sm font-bold mb-2">Edit Time</label>
        <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ $task->scheduled_at }}" class="border rounded w-full py-2 px-3 dark:bg-gray-700">
        @error('scheduled_at')
        <span class="text-red-500 text-xs italic">{{ $message }}</span>
        @enderror
      </div>
      <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
    </form>
  </div>
</x-layouts.app>