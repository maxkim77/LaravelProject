<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            글 목록
        </h2>
        <div>
        <form method="GET" action ="{{route('articles.index')}}">
            <input type="text" name="q" class="rounded border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none text-base px-4 py-2" placeholder="검색어를 입력하세요"> 
            <button type="submit">검색</button>
        </form>
    </div>
    </x-slot>
    <div class="container p-5 mx-auto">
        @foreach($articles as $article)
            <x-list-article-item :article="$article" />
            @endforeach
        </div>
    
    <div class="container p-5">
        {{ $articles->links() }}
    </div>
</x-app-layout>
