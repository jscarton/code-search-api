<?php

namespace App;
use Illuminate\Support\Facades\App;
class CodeSearchApi
{
	// Hold the class instance.
  	private static $instance = null;
	private $services=[];
	private function __construct()
	{
		$available_services=config('jscarton.services');
		foreach ($available_services as $service) {
			$className="App\CodeSearch$service";

			$this->services[$service]= App::make("$className");
		}
	}

	public function search($params=[])
	{
		$results=[];
		foreach ($this->services as $key => $service) {
			$results[$key]=$service->search($params);
		}
		var_dump($results);
		return $results;
	}
 
	// The object is created from within the class itself
	// only if the class has no instance.
	public static function getInstance()
	{
		if (self::$instance == null)
	    {
	      self::$instance = new CodeSearchApi();
	    }
	 
	    return self::$instance;
  }
}
