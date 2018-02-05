<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
/**
 * @Resource("Search", uri="/jscarton/code/search")
 */
class CodeSearchController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
	 * Performs a Search
	 *
	 * Get a JSON representation of all the hits of an user-defined search performed by the webservice in every available API (i.e. github, bitbucket..).
	 * You could include the main search parameters (q, page and per_page) both in the url or as query string parameters. In example:
	 * The following queries to the API are valid:
	 * /jscarton/code/search/hello+world (search files containing "hello world" in every available service, will return the first 25 results by default sorted by score in order desc)
	 * /jscarton/code/search/hello+world/2 (the same as above but will return the results of page 2)
	 * /jscarton/code/search/hello+world/2/10 (this one will return the page 2 of the search results but only 10 hits per page)
	 * /jscarton/code/search/hello+world?page=2&per_page=10 (the same as above)
	 * /jscarton/code/search/?q=hello+world&page=2&per_page=10 (the same as above)
	 * @Versions({"v1"})
	 * @Get("/{q}/{page/{per_page}}")
	 * @Request("/?q=foo&page=2&per_page=2")
 	 * @Response(200, headers={"Content-Type": "application/json"},body={"Github": {"total_hits": 105847570,"page": "2","resultCount": 2,"hits":{{"owner": "jillesvangurp","repository": "jsonj","file": "test_malformed_2.json"},{"owner": "bublik","repository": "medicina","file": "foo.txt"}}}})
 	 * @Parameters({
 	 *      @Parameter("q", type="string", required=true, description="This is the main parameter to perform a search and the only one required. You could write your query right as part of the URL (/jscarton/code/search/hello+world) or as a query string parameter (/jscarton/code/search/?q=hello+world)"),      
 	 *		@Parameter("page", type="integer", required=false, description="OPTIONAL send this parameter if you want to get an specific page of the result set. You could write your query right as part of the URL (/jscarton/code/search/hello+world/2) or as a query string parameter (/jscarton/code/search/?q=hello+world&page=2)"),
 	 *		@Parameter("per_page", type="integer", required=false, description="OPTIONAL send this parameter if you want to specify an specific page size of the result set. You could write your query right as part of the URL (/jscarton/code/search/hello+world/2/15, please using this way requires write the page number to) or as a query string parameter (/jscarton/code/search/?q=hello+world&per_page=15)", default=25),
 	 *      @Parameter("sorting", type="string", required=false, description=" OPTIONAL send this parameter in the query string to specify the desired sorting mode. Please note some Services could override this value without notice (/jscarton/code/search/hello+world?sort=score)", default="score"),
 	 *      @Parameter("order", type="string", required=false, description=" OPTIONAL send this parameter in the query string to specify the desired order mode (asc or desc). Please note some Services could override this value without notice (/jscarton/code/search/hello+world?order=asc)", default="desc"),
 	 *      @Parameter("extra", type="integer", required=false, description=" OPTIONAL send this parameter with a value of 1 in the query string to include extra information in the hits results (/jscarton/code/search/hello+world?extra=1)", default="0"),
 	 *      @Parameter("debug", type="integer", required=false, description=" OPTIONAL send this parameter with a value of 1 in the query string to include extra debug information in the result set (/jscarton/code/search/hello+world?debug=1)", default="0")
 	 * })
	 */
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

    public function logger(Request $request)
    {
        error_log('le pego');
    }
}