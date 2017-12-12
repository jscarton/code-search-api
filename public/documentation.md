# CodeSearch

# Search [/jscarton/code/search]

## Performs a Search [GET /jscarton/code/search/{q}/{page/{per_page}}]
Get a JSON representation of all the hits of an user-defined search performed by the webservice in every available API (i.e. github, bitbucket..).

You could include the main search parameters (q, page and per_page) both in the url or as query string parameters. In example:The following queries to the API are all valid

* /jscarton/code/search/hello+world (search files containing "hello world" in every available service, will return the first 25 results by default sorted by score in order desc)

* /jscarton/code/search/hello+world/2 (the same as above but will return the results of page 2)

* /jscarton/code/search/hello+world/2/10 (this one will return the page 2 of the search results but only 10 hits per page)

* /jscarton/code/search/hello+world?page=2&per_page=10 (the same as above)

* /jscarton/code/search/?q=hello+world&page=2&per_page=10 (the same as above)

+ Parameters
    + q: (string, required) - This is the main parameter to perform a search and the only one required. You could write your query right as part of the URL (/jscarton/code/search/hello+world) or as a query string parameter (/jscarton/code/search/?q=hello+world)
    + page: (integer, optional) - OPTIONAL send this parameter if you want to get an specific page of the result set. You could write your query right as part of the URL (/jscarton/code/search/hello+world/2) or as a query string parameter (/jscarton/code/search/?q=hello+world&page=2)
    + per_page: (integer, optional) - OPTIONAL send this parameter if you want to specify an specific page size of the result set. You could write your query right as part of the URL (/jscarton/code/search/hello+world/2/15, please using this way requires write the page number to) or as a query string parameter (/jscarton/code/search/?q=hello+world&per_page=15)
        + Default: 25
    + sorting: (string, optional) -  OPTIONAL send this parameter in the query string to specify the desired sorting mode. Please note some Services could override this value without notice (/jscarton/code/search/hello+world?sort=score)
        + Default: score
    + order: (string, optional) -  OPTIONAL send this parameter in the query string to specify the desired order mode (asc or desc). Please note some Services could override this value without notice (/jscarton/code/search/hello+world?order=asc)
        + Default: desc
    + extra: (integer, optional) -  OPTIONAL send this parameter with a value of 1 in the query string to include extra information in the hits results (/jscarton/code/search/hello+world?extra=1)
        + Default: 0
    + debug: (integer, optional) -  OPTIONAL send this parameter with a value of 1 in the query string to include extra debug information in the result set (/jscarton/code/search/hello+world?debug=1)
        + Default: 0

+ Request (application/json)
    + Body

            "/?q=foo&page=2&per_page=2"

+ Response 200 (application/json)
    + Headers

            Content-Type: application/json
    + Body

            {
                "Github": {
                    "total_hits": 105847570,
                    "page": "2",
                    "resultCount": 2,
                    "hits": [
                        {
                            "owner": "jillesvangurp",
                            "repository": "jsonj",
                            "file": "test_malformed_2.json"
                        },
                        {
                            "owner": "bublik",
                            "repository": "medicina",
                            "file": "foo.txt"
                        }
                    ]
                }
            }