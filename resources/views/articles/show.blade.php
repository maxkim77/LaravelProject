<x-app-layout>
    <div class = "container p-5 mx-auto">
            <div class="background-white border rounded mb-3 p-3">
                {{ $article->body }}
                <x-article-button-group :article="$article" />
    </div>
    <div class = "mt-3">
        <form action="{{ route('comments.store')}}" method="POST">
        @csrf
        <input type="hidden" name="article_id" value="{{ $article->id }}">
        <x-text-input name="body" class="mr-2"/>
        @error('body')
        <x-input-error :messages=$messages />
        @enderror   
        <x-primary-button>댓글 작성</x-primary-button>
        </form>
    </div>
    </div>
</x-app-layout>