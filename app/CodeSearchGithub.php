<?php

namespace App;
use Milo\Github\Api;
class CodeSearchGithub extends CodeSearchApiWrapper
{
	protected $github;

    public function __construct(Api $github)
    {
        $this->github = $github;
    }     
    
    public function search($params=[])
    {        
        try{
            if (!isset($params['q']))
                throw new \Exception("Error Processing Request: parameter q is mandatory", 500);
                
         	if (!isset($params['per_page']))
                $params['per_page']=25;
    		$response = $this->github->get('/search/code',$params,['Authorization'=>'BEARER '.env('GITHUB_API_TOKEN')]);
    		$result = $this->github->decode($response);
    		return $this->format($result);
        }
        catch (\Exception $e)
        {
            throw $e;
            
        }
    }
    public function format($results)
    {
        if (isset($results->total_count)){
            $formated_results=[
         		'total_hits'=>$results->total_count,
         		'resultCount'=>count($results->items),
         		'hits'=>[]
         	];
         	foreach ($results->items as $hit) {
         		$formated_results['hits'][]=[
         			'file'=>$hit->name,
         			'fileUrl'=>$hit->html_url,
         			'repository'=>$hit->repository->name,
         			'repositoryUrl'=>$hit->repository->html_url,
         			'owner'=>$hit->repository->owner->login,
         			'ownerUrl'=>$hit->repository->owner->html_url,
         			'score'=>$hit->score
         		];
         	}
        }
        else
            return $results;
     	return $formated_results;
    }
}
