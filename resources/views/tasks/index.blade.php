<x-layouts.app :title="__('Task一覧')">
  <div class="p-6">
    <h2 class="font-semibold text-xl mb-4">{{ __('みんなのTask一覧') }}</h2>
    @foreach ($tasks as $task)
    <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
      <p>{{ $task->task }}</p>
    @if($task->completed->contains($task->user_id))
    <p class="text-green-700">予定時刻:{{ $task->scheduled_at->format('Y-m-d H:i') }}</p>
    @elseif($task->scheduled_at->isPast() && ! $task->completed->contains($task->user_id))
    <p class="text-red-500">予定時刻:{{ $task->scheduled_at->format('Y-m-d H:i') }}</p>
      @else 
      <p class="text-gray-300">予定時刻:{{ $task->scheduled_at->format('Y-m-d H:i') }}</p>
      @endif
      <a href="{{ route('profile.show', $task->user) }}">
        <p class="text-sm text-gray-500">投稿者: {{ $task->user->name }}</p>
      </a>
      <a href="{{ route('tasks.show', $task) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>
        <div class="flex mt-2">
        @if ($task->user_id == auth()->id())
            @if ($task->completed->contains(auth()->id()))
            <form action="{{ route('tasks.not_completed', $task) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500 hover:text-red-700">cancel complete</button>
            </form>
            @else
            <form action="{{ route('tasks.complete', $task) }}" method="POST">
            @csrf
            <button type="submit" class="text-blue-500 hover:text-blue-700">complete</button>
            </form>
            @endif
        @else
            @if ($task->completed->contains($task->user_id))
            <p class="text-blue-500"> completed</p>
            @else
            <p class="text-red-500"> not completed</p>
            @endif
        @endif
      </div>
    </div>
    @endforeach
  </div>
</x-layouts.app>