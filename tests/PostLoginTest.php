<?php

namespace App\Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class PostLoginTest extends TestCase
{
    public function testPostLoginWorks()
    {
        $client = new Client(array(
            'base_uri' => 'http://localhost'
        ));

        $data = array(
            '_username' => 'hi.oleksiv@gmail.com',
            '_password' => 'secret',
        );
        $response = $client->post('/api/login_check', [
            'body' => json_encode($data),
            'headers' => array(
                'Content-Type' => 'application/json'
            )
        ]);
        $data = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('token', $data);
    }
}
