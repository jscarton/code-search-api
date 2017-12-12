<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\App;

class GithubApiWrapperTest extends TestCase
{
    /**
     * Create an instance of App\CodeSearchGithub class
     *
     * @return void
     */
    public function testInitialization()
    {
    	$githubSearch=App::make("App\CodeSearchGithub");
        $this->assertTrue($githubSearch instanceof \App\CodeSearchGithub);
    }
    /**
     * test passing an empty call to the search method
     * @expectedException     Exception
     * @expectedExceptionCode 500
     */
    
    public function testEmptyCall()
    {
    	$githubSearch=App::make("App\CodeSearchGithub");
    	$this->assertTrue($githubSearch instanceof \App\CodeSearchGithub);	
    	$githubSearch->search();        
    }
    /**
     * A basic test of github search
     *
     * @return void
     */
    public function testSearch()
    {
        $githubSearch=App::make("App\CodeSearchGithub");
        $this->assertTrue($githubSearch instanceof \App\CodeSearchGithub);	
        $results=$githubSearch->search(['q'=>'jscarton']);
        $this->assertArrayHasKey('total_hits',$results);
    }
    /**
     * A basic test pagination.
     *
     * @return void
     */
    public function testPagination()
    {
        $githubSearch=App::make("App\CodeSearchGithub");
        $this->assertTrue($githubSearch instanceof \App\CodeSearchGithub);	
        $resultsWithoutPagination=$githubSearch->search(['q'=>'jscarton']);
        $this->assertArrayHasKey('total_hits',$resultsWithoutPagination);
        $this->assertArrayHasKey('hits',$resultsWithoutPagination);
        $resultsWithPagination=$githubSearch->search(['q'=>'jscarton','per_page'=>10,'page'=>2]);
        $this->assertArrayHasKey('total_hits',$resultsWithPagination);
        $this->assertArrayHasKey('hits',$resultsWithPagination);
        $this->assertNotEquals($resultsWithPagination['resultCount'],$resultsWithoutPagination['resultCount']);
        $this->assertNotEquals($resultsWithPagination['hits'][0]['file'],$resultsWithoutPagination['hits'][0]['file']);
    }
}
