<?php

namespace App;
use Illuminate\Support\Facades\App;

/**
 *
 *	Implements the code search api entry point
 *
 */
class CodeSearchApi
{
	/**
	 *
	 *	Hold the singleton instance
	 *
	 */
  	private static $instance = null;
  	/**
	 *
	 *	Available service providers
	 *
	 */
	private $services=[];
	/**
	 *
	 *	Initializes the CodeSearchApi object
	 *
	 */
	private function __construct()
	{
		$available_services=config('jscarton.services');
		foreach ($available_services as $service) {
			$className="App\CodeSearch$service";

			$this->services[$service]= App::make("$className");
		}
	}

	/**
	 *
	 *	Perform the search using every available service
	 *
	 */
	public function search($params=[])
	{
		$results=[];		
		$globalStartTime=time();
		foreach ($this->services as $key => $service) {			
			$partialStartTime=time();	
			$results[$key]=$service->search($params);
			$partialEndTime=time();
			if (isset($params['debug']) && $params['debug']=='1')
				$results[$key]['time_elapsed_in_seconds']=$partialEndTime-$partialStartTime;
		}
		$globalEndTime=time();
		if (isset($params['debug']) && $params['debug']=='1')
				$results['time_elapsed_in_seconds']=$globalEndTime-$globalStartTime;
		return $results;
	}

	/**
	 *
	 *	The object is created from within the class itself only if the class has no instance.
	 *
	 */ 	 
	public static function getInstance()
	{
		if (self::$instance == null)
	    {
	      self::$instance = new CodeSearchApi();
	    }
	 
	    return self::$instance;
  }
}
