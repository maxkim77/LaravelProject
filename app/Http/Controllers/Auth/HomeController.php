<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke(Request $request)
    {
        $articles = Article::with('user')
            ->withCount('comments')
            ->withExists([
                'comments as recent_comments_exists' => function ($query) {
                    $query->where('created_at', '>', now()->subDay());
                }
            ])
            ->when(Auth::check(), function ($query) {
                $query->whereHas('user', function (Builder $query) {
                    $query->whereIn('id', Auth::user()->followers()->pluck('follower_id'));
                });
            })
            ->latest()
            ->paginate(10);

        return view('welcome', ['articles' => $articles]);
    }
}
