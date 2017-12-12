<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicApiCallTest()
    {
        $response = $this->get('/jscarton/code/search/foo/2/2');

        $response->assertStatus(200);
    }
}
