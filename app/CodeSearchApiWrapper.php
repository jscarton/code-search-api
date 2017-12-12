<?php

namespace App;

/**
 *
 *	Abstract class. Every Search API Wrapper should be descendant of this class
 *
 */
abstract class CodeSearchApiWrapper
{
	/**
	 *
	 *	Performs the Search
	 *
	 */
    public abstract function search($params);
    /**
	 *
	 *	format the results
	 *
	 */
    public abstract function format($results,$params);
}
