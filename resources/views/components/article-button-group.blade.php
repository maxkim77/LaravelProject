<div class="flex flex-row">
    @can('update', $article)
        <a class="button rounded bg-blue-500 px-4 py-2 py-1 text-white" href="{{ route('articles.edit', ['article' => $article->id]) }}">수정하기</a>
            <form action="{{ route('articles.destroy', ['article' => $article->id]) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="button rounded bg-red-500 px-4 py-2 py-1 text-white" type="submit">삭제하기</button>
            </form>
    @endcanany
 </div>
    