<?php

namespace KnpU\CodeBattle\Tests\Controller\Api;

use Guzzle\Http\Client;

class ProgrammerControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testPOST()
    {
        // create our http client (Guzzle)
        $client = new Client('http://localhost:8000', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));

        $nickname = 'ObjectOriented' . mt_rand(0, 999);
        $data = [
            'nickname' => $nickname,
            'avatarNumber' => 5,
            'tagLine' => 'A test dev!'
        ];

        $request = $client->post('/api/programmers', null, json_encode($data));
        $response = $request->send();

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));
        $data = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('nickname', $data);
    }
}