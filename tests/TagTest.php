<?php

use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CategoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    /**
     * List all articles.
     *
     * @return void
     */
    public function testCategoryListAll()
    {
        $this->get('/api/v1/categories/all', []);
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'category',
                    'article_count',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }
    public function testViewCategoryById()
    {
        
        // //paases when the correct article id is passed
         $this->json('get',
            'api/v1/categories/view/1',
            [],
            ['api_token' => '3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60']
        )
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'status',
                'message',
                'data' => ['*' => ['category', 'article_count', 'articles' => ['*' => ['article', 'comments']]]]
            ]);
    }
    public function testViewArticleWithWrongId(){
        //handles when wrong article id is set
        $this->json('get',
            'api/v1/categories/view/0',
            [],
            ['api_token' => '3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60']
        )->seeStatusCode(404)
            ->seeJsonEquals([
                'message' => "Category not found.",
                'status' => 404,
                "data" => "No query results for model [App\\Model\\Category]."
            ]);
    }
public function testViewArticleByUnathenticatedUser(){
    ///Test for unauthenticted users
    $this->json('get','api/v1/categories/view/10', [])
    ->seeStatusCode(401)
    ->seeJsonEquals([
        'message' => "Unauthorized.",
        'status' => 401,

    ]);
}
    public function testAddCategory()
    {

        //Make Authorized request
        $title = str_random(5);
        $this->json(
            'post',
            'api/v1/categories/add',
            [
                'category' => $title,
                'article_count' => 0,

            ],
            ['api_token' => '3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60']
        )->seeStatusCode(200)->seeJsonStructure(['status', 'data', 'message']);
    }

    public function testAddArticleUnauthorise()
    {
        $title = 'Helpp me sir';
        $this->json(
            'post',
            'api/v1/categories/add',
            [
                'category' => $title,
                'article_count' => 0,

            ],
            ['api_tokens' => '3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60']
        )->seeStatusCode(401)->seeJsonEquals(['message' => 'Unauthorized.', 'status' => 401]);
    }

    public function testEditCategory()
    {


        //Make Authorized request
        $title = 'Tessters';
        $this->json(
            'post',
            'api/v1/categories/edit/1',
            [
                'category' => $title,
                'article_count' => 0,

            ],
            ['api_token' => '3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60']

        )->seeStatusCode(200)->seeJsonStructure(['status', 'data', 'message']);
    }

    public function testEditCategoryUnauthorise()
    {


        //Make Authorized request
        $title = 'Helpp me sir';
        $this->json(
            'post',

            'api/v1/categories/edit/1',
            [
                'category' => $title,
                'article_count' => 0,

            ],
            ['api_tokens' => '3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60']
        )->seeStatusCode(401)->seeJsonEquals(['message' => 'Unauthorized.', 'status' => 401]);
    }

 
}
