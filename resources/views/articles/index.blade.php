<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            글 목록
        </h2>
    </x-slot>
    
    <div class="container p-5">
        @foreach($articles as $article)
            <div class="background-white border rounded mb-3 p-3">
                <p>{{ $article->body }}</p>
                <p>{{ optional($article->user)->name }}</p>
                <!-- 글조회 -->
                <p class="mt-2">
                    <a href="{{ route('articles.show', ['article' => $article->id]) }}">
                        {{ $article->created_at->diffForHumans() }}
                    </a>
                </p>
                <!-- 수정 및 삭제 버튼 -->
                <div class="flex flex-row">
                    @canany(['update','delete'], $article)
                    <a class="button rounded bg-blue-500 px-4 py-2 py-1 text-white" href="{{ route('articles.edit', ['article' => $article->id]) }}">수정하기</a>
                    <form action="{{ route('articles.destroy', ['article' => $article->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="button rounded bg-red-500 px-4 py-2 py-1 text-white" type="submit">삭제하기</button>
                    </form>
                    @endcanany
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="container p-5">
        {{ $articles->links() }}
    </div>
</x-app-layout>
