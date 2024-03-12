<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ArticleControllertest extends TestCase
{   use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function 글쓰기_화면(): void
    {
        $this->get('/articles/create')->assertStatus(200);
    }

    public function 글쓰기_작성(): void
    {
        $user = User::factory()->create();
        $this-actingAs($user)
        ->post(route('articles.store'), [
            'body' => 'test body',
        ])->assertRedirect(route('articles.index'));
        $this->assertDatabaseHas('articles', [
            'body' => 'test body',
        ]);
    }
    public function 글쓰기_저장(): void
    {
        $this->post('/articles', [
            'body' => 'test body',
        ])->assertRedirect('/articles');

        $this->assertDatabaseHas('articles', [
            'body' => 'test body',
        ]);
    }
    public function 글목록(): void
    {
        $this->get('/articles')->assertStatus(200);
    }   
    
    public function 개별글조회(): void
    {
        $this->get('/articles/1')->assertStatus(200);
    }


    public function 개별글삭제(): void
    {
        $this->delete('/articles/1')->assertRedirect('/articles');
        $this->assertDatabaseMissing('articles', ['id' => 1]);
    }   
}
