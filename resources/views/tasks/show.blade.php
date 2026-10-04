<x-layouts.app :title="__('Task詳細')">
  <div class="p-6">
    <a href="{{ route('tasks.index') }}" class="text-blue-500 hover:text-blue-700">一覧に戻る</a>
    <p class="text-lg mt-2">{{ $task->task }}</p>
    @if($task->completed->contains($task->user_id))
    <p class="text-m text-green-700">予定時刻:{{ $task->updated_at->format('Y-m-d H:i') }}</p>
    @elseif($task->scheduled_at->isPast() && ! $task->completed->contains($task->user_id))
    <p class="text-m text-red-500">予定時刻:{{ $task->updated_at->format('Y-m-d H:i') }}</p>
      @else 
      <p class="text-m text-gray-300">予定時刻:{{ $task->updated_at->format('Y-m-d H:i') }}</p>
      @endif
    <p class="text-sm text-gray-500">投稿者: {{ $task->user->name }}</p>
    <p class="text-sm text-gray-500">作成日時: {{ $task->created_at->format('Y-m-d H:i') }}</p>
    <p class="text-sm text-gray-500">更新日時: {{ $task->updated_at->format('Y-m-d H:i') }}</p>
    @if (auth()->id() == $task->user_id)
    <div class="flex mt-4">
      <a href="{{ route('tasks.edit', $task) }}" class="text-blue-500 hover:text-blue-700 mr-2">編集</a>
      <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-500 hover:text-red-700">削除</button>
      </form>
    </div>
        <div class="flex mt-4">
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
</x-layouts.app>