<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class CodeSearchController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    public function index(Request $request,$q=null,$page=null,$per_page=25)
    {
    	if (is_null($page) && $request->query('q',false))
    		$q=$request->query('q');
    	if (is_null($page) && $request->query('page',false))
    		$page=$request->query('page');
    	if ($request->query('per_page',false))
    		$per_page=$request->query('per_page');
    	$params=[
    			'q'=>$q,
    			'page'=>$page,
    			'per_page'=>$per_page,
    			'sort'=>$request->query('sort','score'),
    			'order'=>$request->query('order','desc'),
    			'extra'=>$request->query('extra','false'),
    			'debug'=>$request->query('debug','false')];
    	$results=\App\CodeSearchApi::getInstance()->search($params);
    	if (isset($params['debug']) && $params['debug']=='1')
    		$results['parameters']=$params;
    	return $results;
    }
}
