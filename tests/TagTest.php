<?php

use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TagsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    /**
     * List all Tags.
     *
     * @return void
     */
    public function testCategoryListAll()
    {
        $this->get('/api/v1/tags/all', []);
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'tag',
                    
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }
    public function testViewCategoryById()
    {
        
        // //paases when the correct Tags id is passed
         $this->json('get',
            'api/v1/tags/view/1',
            [],
            ['api_token' => '3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60']
        )
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'status',
                'message',
                'data' => ['*' => ['tag', 'articles' => ['*' => ['categories', 'comments']]]]
            ]);
    }
    public function testViewTagsWithWrongId(){
        //handles when wrong Tags id is set
        $this->json('get',
            'api/v1/tags/view/0',
            [],
            ['api_token' => '3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60']
        )->seeStatusCode(404)
            ->seeJsonEquals([
                'message' => "Tag not found",
                'status' => 404,
                "data" => "No query results for model [App\\Model\\Tag]."
            ]);
    }
public function testViewTagsByUnathenticatedUser(){
    ///Test for unauthenticted users
    $this->json('get','api/v1/tags/view/10', [])
    ->seeStatusCode(401)
    ->seeJsonEquals([
        'message' => "Unauthorized.",
        'status' => 401,

    ]);
}
    public function testAddTag()
    {

        //Make Authorized request
        $title = str_random(5);
        $this->json(
            'post',
            'api/v1/tags/add',
            [
                'tag' => $title,
                
            ],
            ['api_token' => 'OvaFVhgsv5JP1NJ5Do213dkMW3PQF7VgvRiGoYUJ3967f9ygDdvCzv6LpBwH5d56d692bfc48']
        )->seeStatusCode(200)->seeJsonStructure(['status', 'data', 'message']);
    }

    public function testAddTagUnauthorise()
    {
        $title = 'Helpp me sir';
        $this->json(
            'post',
            'api/v1/tags/add',
            [
                'category' => $title,
                'Tags_count' => 0,

            ],
            ['api_tokens' => 'OvaFVhgsv5JP1NJ5Do213dkMW3PQF7VgvRiGoYUJ3967f9ygDdvCzv6LpBwH5d56d692bfc48']
        )->seeStatusCode(401)->seeJsonEquals(['message' => 'Unauthorized.', 'status' => 401]);
    }

    public function testEditCategory()
    {


        //Make Authorized request
        $title = 'Tessters';
        $this->json(
            'post',
            'api/v1/tags/edit/2',
            [
                'tag' => $title,
             ],
            ['api_token' => 'OvaFVhgsv5JP1NJ5Do213dkMW3PQF7VgvRiGoYUJ3967f9ygDdvCzv6LpBwH5d56d692bfc48']

        )->seeStatusCode(200)->seeJsonStructure(['status', 'data', 'message']);
    }

    public function testEditCategoryUnauthorise()
    {


        //Make Authorized request
        $title = 'Helpp me sir';
        $this->json(
            'post',

            'api/v1/tags/edit/2',
            [
                'tag' => $title,
                

            ],
            ['api_tokens' => '3Y1DtvpXvSfgZGfi4CEmvhWzyQwGk1o6NKPUBfmminMTfgthY0F6Nv21uurJ5d56d692bac60']
        )->seeStatusCode(401)->seeJsonEquals(['message' => 'Unauthorized.', 'status' => 401]);
    }

 
}
