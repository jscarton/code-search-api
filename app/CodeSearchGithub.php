<?php

namespace App;
use GrahamCampbell\GitHub\GitHubManager;

class CodeSearchGithub extends CodeSearchApiWrapper
{
	protected $github;

    public function __construct(GitHubManager $github)
    {
        $this->github = $github;
    }

     public function search($params=[])
     {
     	return $this->github->issues()->show('woocommerce', 'woocommerce', 2);
     }
}
