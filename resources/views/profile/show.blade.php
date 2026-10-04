<x-layouts.app :title="__('User詳細')">
  <div class="p-6">
    <h2 class="font-semibold text-xl mb-4">{{ __('User詳細') }}</h2>
    <a href="{{ route('tasks.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">一覧に戻る</a>
    <p class="text-lg mt-2">{{ $user->name }}</p>
    <div class="text-sm text-gray-500">
      <p>アカウント作成日時: {{ $user->created_at->format('Y-m-d H:i') }}</p>
    </div>
    <div class="text-sm text-green-500">
      <p>完了したタスク数: {{ $completedCount }}</p>
    </div>
    <div class="text-sm text-red-500">
      <p>未完了のタスク数: {{ $incompleteCount }}</p>
    </div>
    

    <h3 class="font-semibold text-lg mt-6 mb-2">{{ $user->name }} のTask</h3>

    @forelse ($tasks as $task)
    @php
      $isDone = $task->completed->contains($task->user_id);
    @endphp
    <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
      <p>{{ $task->task }}</p>

      @if ($isDone)
        <p class="text-sm text-green-700">予定時刻: {{ $task->scheduled_at->format('Y-m-d H:i') }}</p>
      @elseif ($task->scheduled_at->isPast())
        <p class="text-sm text-red-500">予定時刻: {{ $task->scheduled_at->format('Y-m-d H:i') }}</p>
      @else
        <p class="text-sm text-gray-500">予定時刻: {{ $task->scheduled_at->format('Y-m-d H:i') }}</p>
      @endif

      <p class="text-sm text-gray-500">投稿者: {{ $task->user->name }}</p>
      <a href="{{ route('tasks.show', $task) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>

      <div class="flex mt-2">
        @if ($task->user_id == auth()->id())
          @if ($isDone)
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
          @if ($isDone)
            <p class="text-blue-500">completed</p>
          @else
            <p class="text-red-500">not completed</p>
          @endif
        @endif
      </div>
    </div>
    @empty
      <p class="text-sm text-gray-500">まだTaskがありません。</p>
    @endforelse
  </div>
</x-layouts.app>