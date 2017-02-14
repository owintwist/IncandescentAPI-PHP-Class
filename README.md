IncandescentAPI PHP Class v0.2
==============================

Simple PHP Class for IncandescentAPI

Install
-------

Edit the file `IncandescentAPI.class.php` and enter your `UID` and `KEY` in `const` fields. If your `UID` is _1234_ and your `KEY`is _1234567890abcdef_, your configuration must look like :

	/// Configuration
	const UID = '1234';					// Your API UID
	const KEY = '1234567890abcdef';		// Your API KEY
	const EXPIRES = 300;				// Default auth expiration delay
	const FILTERSDIR = '.';			// Filters' dir without ending "/"

Load it on your scripts :  

	require_once 'IncandescentAPI.class.php';

Usage
-----

### Add Image ::addImage() 
 
_mixed_ `$project_id` = IncandescentAPI**::addImage** ( _mixed_ `$images` [ , _int_ `$repeat` ] )

Parameter `$images` must be an url string or an array of URLs strings.  
Parameter `$repeat` is the number you want to search for each images (default is **1**).  

Return `$project_id` the request ID for get results or raw result if error.


### Get Results ::getResults()  

_This method did not return filtered results._

_object_ `$results` = IncandescentAPI**::getResults** ( _string_ `$project_id` )

Parameter `$project_id` is a request ID returned by previous **::addImage()**.  

Return `$results` as raw IncandescentAPI results.  
Return `false` if no result.  
See [IncandescentAPI documentation](http://incandescent.xyz)

### Get Multiple Results ::getMergedResults()  

_This method return filtered results._

_object_ `$results` = IncandescentAPI**::getMergedResults** ( _mixed_ `$project_id` )

Parameter `$project_id` is a request ID returned by previous **::addImage()**.  

Return `$results` as raw IncandescentAPI results.  
Return `false` if no result.  


### Get Credits ::getCredits()

_mixed_ `$credits` = IncandescentAPI**::getCredit** ( _null_ )

Need no parameters.  

Return `$credits` the numbers of credits remains or raw results if error.


Using Filters
-------------

v0.2 introduce filters using simple JSON files :

 * `not-match.json` : list all images URL that did not match on any request;  
 * `domains-ignore.json` : list all ignored full domain (for exemple, your own domains).

Directory for this files is running's script dir by default, you can set another dir with `FILTERSDIR` constant, without the ending `/`.  
**Warning** be careful to set something or the Class will find for the filters files in root dir !
