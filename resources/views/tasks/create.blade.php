<x-layouts.app :title="__('Task作成')">
  <div class="p-6">
    <h2 class="font-semibold text-xl mb-4">{{ __('Task作成') }}</h2>
    <form method="POST" action="{{ route('tasks.store') }}">
      @csrf

      <div class="mb-4">
        <label for="task" class="block text-sm font-bold mb-2">Task</label>
        <input type="text" name="task" id="task" class="border rounded w-full py-2 px-3 dark:bg-gray-700">
        @error('task')
        <span class="text-red-500 text-xs italic">{{ $message }}</span>
        @enderror
      </div>

      <div class="mb-4">
        <label for="scheduled_at" class="block text-sm font-bold mb-2">予定時刻</label>
        <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="border rounded w-full py-2 px-3 dark:bg-gray-700">
        @error('scheduled_at')
        <span class="text-red-500 text-xs italic">{{ $message }}</span>
        @enderror
      </div>

      <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Task作成</button>
    </form>
  </div>
</x-layouts.app>