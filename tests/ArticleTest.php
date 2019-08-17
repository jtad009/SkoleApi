<?php

use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ArticleTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        // echo public_path('uploads/5d553a80f0a00-israel.png');
        $_FILES = [
            'cover_image' => [
                'name' => 'test.png',
                'tmp_name' => public_path('uploads/israel.png'),
                'type' => 'image/png',
                'size' => 499999,
                'error' => 0
            ]
        ];
    }
    /**
     * List all articles.
     *
     * @return void
     */
    public function testListAll()
    {
        $this->get('/api/v1/articles/all', []);
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'category_id',
                    'article',
                    'slug',
                    'view_count',
                    'user_id',
                    'cover_image',
                    'comment_count',
                    'published',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }
    public function testViewArticleById()
    {
        //handles when wrong article id is set
        $this->get('api/v1/articles/view/290fc048-bf15-11e9-bb04-f0761cc3045', [])
            ->seeStatusCode(404)
            ->seeJsonEquals([
                'message' => "Not Found",
                'status' => 404,
                "data" => "No query results for model [App\\Model\\Article]."
            ]);
        //paases when the correct article id is passed
        $res = $this->get(
            'api/v1/articles/view/290fc048-bf15-11e9-bb04-f0761cc3045a',
            []
        )
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'status',
                'message',
                'data' => ['*' => ['title', 'slug', 'comments', 'article', 'category_id', 'view_count', 'user_id', 'cover_image', 'published', 'comment_count', 'categories', 'users', 'tags']]
            ]);
    }
    public function testAddArticle()
    {


        //Rejects unauthorised request
        $img  = new \Illuminate\Http\UploadedFile(public_path('uploads/israel.png'), 'israel.png', null, null, null, true);

        //Make Authorized request
        $title = str_random(5);
        $this->json(
            'post',
            'api/v1/articles/add',
            [
                'title' => $title,
                'slug' => str_replace(' ', '-', $title),
                'cover_image' => $_FILES,
                'published' => 1,
                'article' => str_random(20),
                'category_id' => '1',
                'comment_count' => '1',
                'view_count' => '1',
                'user_id' => 1,
                'tag_id' => 1,
                'id'=>'e7be075f-1c22-41cd-bc24-cd7c399a92b8'

            ],
            ['api_token' => '3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60']
        )->seeStatusCode(200)->seeJsonStructure(['status', 'data', 'message']);
    }
    public function testEditArticle()
    {


        //Rejects unauthorised request
        $img  = new \Illuminate\Http\UploadedFile(public_path('uploads/israel.png'), 'israel.png', null, null, null, true);

        //Make Authorized request
        $title = 'Helpp me sir';
        $this->json(
            'post',
            'api/v1/articles/edit/d9fcea07-c32c-48e9-bb56-1c19651ccef6',
            [
                'title' => $title,
                'slug' => str_replace(' ', '-', $title),
                'cover_image' => $_FILES,
                'published' => 1,
                'article' => str_random(20),
                'category_id' => '1',
                'comment_count' => '1',
                'view_count' => '0',
                'user_id' => 1,
                'tag_id' => 1,

            ],
            ['api_token' => '3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60']
        )->seeStatusCode(200)->seeJsonStructure(['status', 'data', 'message']);
    }
    public function testEditArticleeUnauthorise()
    {


        //Rejects unauthorised request
        $img  = new \Illuminate\Http\UploadedFile(public_path('uploads/israel.png'), 'israel.png', null, null, null, true);

        //Make Authorized request
        $title = 'Helpp me sir';
        $this->json(
            'post',
            'api/v1/articles/edit/d9fcea07-c32c-48e9-bb56-1c19651ccef6',
            [
                'title' => $title,
                'slug' => str_replace(' ', '-', $title),
                'cover_image' => $_FILES,
                'published' => 1,
                'article' => str_random(20),
                'category_id' => '1',
                'comment_count' => '1',
                'view_count' => '0',
                'user_id' => 1,
                'tag_id' => 1,

            ],
            ['api_tokens' => '3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60']
        )->seeStatusCode(401)->seeJsonEquals(['message' => 'Unauthorized.', 'status' => 401]);
    }
    public function testAddArticleUnauthorise()
    {
        $this->json(
            'post',
            'api/v1/articles/add',
            [
                'title' => 'New Test Article',
                'slug' => 'New-Test-Article',

                'published' => 1,
                'article' => 'Shalom',
                'category_id' => '1',
                'comment_count' => '1',
                'view_count' => '1',
                'user_id' => 1,
                'tag_id' => 1,

            ],
            ['api_tokens' => '3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60']
        )->seeStatusCode(401)->seeJsonEquals(['message' => 'Unauthorized.', 'status' => 401]);
    }
    public function testDeleteArticle()
    {
        //Delete article with right ID
        $this->json(
            'delete',
            'api/v1/articles/delete/e7be075f-1c22-41cd-bc24-cd7c399a92b8',
            [],
            ['api_token' => '3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60']
        )->seeStatusCode(200)->seeJsonEquals(['message' => 'success', 'status' => 200,'data'=>'Article Deleted']);

        //Fails to delete article with  invalid article ID
        $this->json(
            'delete',
            'api/v1/articles/delete/e7be075f-1c22-41cd-bc24-cd7c399a92b8',
            [],
            ['api_token' => '3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60']
        )->seeStatusCode(404)->seeJsonEquals(['message' => 'Not Found', 'status' => 404,'data'=>"No query results for model [App\\Model\\Article]."]);
    }
}
