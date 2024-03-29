<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteArticleRequest;
use App\Http\Requests\EditArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder; // 필요한 경우 Builder 클래스를 import 합니다.

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);

        // 인증되지 않은 사용자를 차단하는 미들웨어를 설정합니다
    }

    public function index(Request $request)
    {
        // 요청에서 검색 쿼리 매개변수 'q'를 가져옵니다.
        $q = $request->input('q');

        $articles = Article::with('user')
            ->with('comments')
            ->withExists([
                'comments as comments_count' => function ($query) {
                    $query->where('created_at', '>=', Carbon::now()->subDays(7));
                }
            ])
            ->when($q, function ($query) use ($q) { // 클로저 함수 내에서 $query의 타입을 올바르게 지정합니다.
                $query->where('body', 'like', '%' . $q . '%')
                    ->orWhereHas('user', function (Builder $query) use ($q) { // Builder 클래스를 사용합니다.
                        $query->where('name', 'like', '%' . $q . '%');
                    });
            })
            ->latest()
            ->paginate();

        $perPage = 10;
        $perPage = $request->input('perpage', $perPage);
        $totalCount = Article::count();

        return view('articles.index', compact('articles', 'perPage', 'totalCount'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(CreateArticleRequest $request)
{
    $validatedData = $request->validated();

    $article = Article::create([
        'body' => $validatedData['body'],
        'user_id' => auth()->id(),
    ]);

    if ($article) {
        return redirect()->route('articles.index')->with('success', '글이 성공적으로 작성되었습니다.');
    } else {
        return back()->withInput()->with('error', '글 작성에 실패했습니다. 다시 시도해주세요.');
    }
}


    public function show(Article $article)
    {
        $article->load('comments.user');
        $article->loadCount('comments');
        return view('articles.show', compact('article'));
    }

    public function edit(EditArticleRequest $request, Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        $validatedData = $request->validated();

        $article->update($validatedData);

        return redirect()->route('articles.show', ['article' => $article->id]);
    }

    public function destroy(DeleteArticleRequest $request, Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }
}
