<?php

namespace Tests\Feature;

use Tests\TestCase;

class CodeSearchApiTest extends TestCase
{
    /**
     * Get an instance of App\CodeSearchApi class
     *
     * @return void
     */
    public function testInitialization()
    {
    	$cs=\App\CodeSearchApi::getInstance();
        $this->assertTrue($cs instanceof \App\CodeSearchApi);
    }
    /**
     * test passing an empty call to the search method
     * @expectedException     Exception
     * @expectedExceptionCode 500
     */
    
    public function testEmptyCall()
    {
    	$cs=\App\CodeSearchApi::getInstance();
        $this->assertTrue($cs instanceof \App\CodeSearchApi);
    	$cs->search();        
    }
    /**
     * A basic test of github search
     *
     * @return void
     */
    public function testSearch()
    {
        $cs=\App\CodeSearchApi::getInstance();
        $this->assertTrue($cs instanceof \App\CodeSearchApi);
        $results=$cs->search(['q'=>'jscarton']);
        $this->assertArrayHasKey('Github',$results);
    }
    /**
     * A basic test pagination.
     *
     * @return void
     */
    public function testPagination()
    {
        $cs=\App\CodeSearchApi::getInstance();
        $this->assertTrue($cs instanceof \App\CodeSearchApi);
        $resultsWithoutPagination=$cs->search(['q'=>'jscarton']);
        $this->assertArrayHasKey('Github',$resultsWithoutPagination);
        $this->assertArrayHasKey('hits',$resultsWithoutPagination['Github']);
        $resultsWithPagination=$cs->search(['q'=>'jscarton','per_page'=>10,'page'=>2]);
        $this->assertArrayHasKey('Github',$resultsWithPagination);
        $this->assertArrayHasKey('hits',$resultsWithPagination['Github']);
        $this->assertNotEquals($resultsWithPagination['Github']['resultCount'],$resultsWithoutPagination['Github']['resultCount']);
        $this->assertNotEquals($resultsWithPagination['Github']['hits'][0]['file'],$resultsWithoutPagination['Github']['hits'][0]['file']);
    }
}
