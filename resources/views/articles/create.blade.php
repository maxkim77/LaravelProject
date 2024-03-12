<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            새 글 쓰기
        </h2>
    </x-slot>

    <div class="container p-5">
        <form action="{{ route('articles.store') }}" method="POST" class="mt-5">
            @csrf
            <div class="mb-3">
                <label for="body" class="block">내용</label>
                <input type="text" id="body" name="body" class="block w-full rounded @error('body') border-red-500 @enderror" value="{{ old('body') }}" required>
                @error('body')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="py-1 px-3 bg-black text-white rounded text-xs">저장하기</button>
        </form>
    </div>
</x-app-layout>
