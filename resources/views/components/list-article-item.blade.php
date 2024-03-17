<div class="background-white border rounded mb-3 p-3">

    <p>{{ $article->body }}</p>

    @if ($article->user) <!-- $article->user가 존재하는지 확인합니다 -->
        <p>
            <a href="{{ route('profile', ['user' => $article->user->id]) }}">
                @if ($article->user)
                    {{ $article->user->name }}
                @endif
            </a>
        </p>
    @endif

    <!-- 글조회 -->

    <p class="text-xs text-gray-500">
        <a href="{{ route('profile', ['user' => $article->user->id]) }}">
            {{ $article->created_at->diffForHumans() }}
            <span>댓글 {{ $article->comments_count }} @if($article->recent_comments_exists) (new) @endif</span>
        </a>
    </p>

    <!-- 수정 및 삭제 버튼 -->

    <x-article-button-group :article="$article" />

</div>
