<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);

        // 인증되지 않은 사용자를 차단하는 미들웨어를 설정합니다
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perpage', 10);
        $articles = Article::with('user')->latest()->paginate($perPage);
        $totalCount = Article::count();
        return view('articles.index', compact('articles', 'perPage', 'totalCount'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'body' => 'required|string|max:255',
    ]);

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
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'body' => 'required|string|max:255',
        ]);

        $article->update($validatedData);

        return redirect()->route('articles.show', ['article' => $article->id]);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }
}
