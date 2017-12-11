<?php

namespace App;
use GrahamCampbell\Bitbucket\BitbucketManager;

class CodeSearchBitbucket extends CodeSearchApiWrapper
{
	protected $bitbucket;

    public function __construct(BitbucketManager $bitbucket)
    {
        $this->bitbucket = $bitbucket;
    }

     public function search($params=[])
     {
     	return $this->bitbucket->api('Repositories\Issues')->all('gentlero', 'bitbucket-api');
     }
}
