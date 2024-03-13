<x-app-layout>
    <div class = "container p-5 mx-auto">
            <div class="background-white border rounded mb-3 p-3">
                <p>{{ $article->body }}</p>
                <p class="text-sm text-gray">{{ $article->user->name}} {{ $article->created_at->toDateTimeString() }}</p>
                <p class="text-sm text-gray">{{ $article->comments_count }}개의 댓글</p>
                
                <x-article-button-group :article="$article" />
    </div>


    <h2 class="text-lg font-bold">댓글</h2>
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
        <!-- 댓글 목록시작 -->
        <div class="mt-4">
            @foreach($article->comments as $comment)
            <div class="mt-4">
                <p>{{ $comment->body }}</p>
                <p class="text-sm text-gray">{{ $comment -> user -> name}} {{ $article -> created_at -> toDateTimeString() }}</p>
            </div>
            @endforeach
    </div>
    </div>
</x-app-layout>