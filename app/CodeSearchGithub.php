<?php

namespace App;
use Milo\Github\Api;
/**
 *
 *  Implements the Github code search api
 *
 */
class CodeSearchGithub extends CodeSearchApiWrapper
{
    /**
     *
     *  Holds the github API client
     *
     */
	protected $github;

    /**
     *
     *  Class constructor.
     * 
     *  To instantiate and object of this class use: App::make("App\CodeSearchGithub"). This will inject the $github object.
     *
     */
    public function __construct(Api $github)
    {
        $this->github = $github;
    }     
    /**
     *
     *  Search method.
     * 
     *  The expected params are q, page, per_page and also you can use the github API query modifiers
     *
     */
    public function search($params=[])
    {        
        try{
            if (!isset($params['q']))
                throw new \Exception("Error Processing Request: parameter q is mandatory", 500);
                
         	if (!isset($params['per_page']))
                $params['per_page']=25;
    		$response = $this->github->get('/search/code',$params,['Authorization'=>'BEARER '.env('GITHUB_API_TOKEN')]);
    		$result = $this->github->decode($response);
    		return $this->format($result,$params);
        }
        catch (\Exception $e)
        {
            throw $e;
            
        }
    }
    /**
     *
     *  Formats the output.
     * 
     *  transform github API results into Jscarton's output format
     *
     */
    public function format($results,$params)
    {
        if (isset($results->total_count)){
            $formated_results=[
         		'total_hits'=>$results->total_count,
                'page'=>isset($params['page'])&&!is_null($params['page'])?$params['page']:"1",
         		'resultCount'=>count($results->items),                
         		'hits'=>[]
         	];
         	foreach ($results->items as $hit) {
         		$hit_data=[
                    'owner'=>$hit->repository->owner->login,
                    'repository'=>$hit->repository->name,
                    'file'=>$hit->name,                    
                ];
                if (isset($params['extra']) && $params['extra']=='1'){
                    $hit_data['repositoryUrl']=$hit->repository->html_url;
                    $hit_data['ownerUrl']=$hit->repository->owner->html_url;
                    $hit_data['fileUrl']=$hit->html_url;                    
                    $hit_data['score']=$hit->score;
                    
                }
                $formated_results['hits'][]=$hit_data;
         	}
        }
        else
            return $results;
     	return $formated_results;
    }
}
