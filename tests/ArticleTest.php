<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class ArticleTest extends TestCase
{
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
                'data' => ['*' => ['title','slug','comments','article','category_id','view_count','user_id','cover_image','published','comment_count','categories','users','tags']]
            ]);
    
    }
    public function testAddArticle(){
        $this->post(
            'api/v1/articles/add/',
            [
                'title'=>'New Test Article',
                'slug'=>'New-Test-Article',
                'cover_image'=>'',
                'published'=>1,
                'article'=>'Shalom',
                'category_id'=>'1',
                'comment_count'=>'1',
                'view_count'=>'1',
                'user_id'=>1,
                'tag_id'=>1
            ],
            ['api_token'=>'3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60'])
    }
}
