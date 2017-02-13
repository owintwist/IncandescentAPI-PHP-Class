IncandescentAPI PHP Class v0.1
==============================

Simple PHP Class for IncandescentAPI

Install
-------

Edit the file `IncandescentAPI.class.php` and enter your `UID` and `KEY` in first `const` fields.

Load it on your scripts :  

	require_once 'IncandescentAPI.class.php';

Usage
-----

### Add Image : 
 
_mixed_ `$project_id` = IncandescentAPI**::addImage** ( _mixed_ `$images` [ , _int_ `$repeat` ] )

Parameter `$images` must be an url string or an array of URLs strings.  
Parameter `$repeat` is the number you want to search for each images (default is **1**).  

Return `$project_id` the request ID for get results or raw result if error.


### Get Results :  

_object_ `$results` = IncandescentAPI**::getImage** ( _string_ `$project_id` )

Parameter `$project_id` is a request ID returned by previous **::addImage()**.  

Return `$results` as raw IncandescentAPI results.  
Return `false` if no result.  
See [IncandescentAPI documentation](http://incandescent.xyz)


### Get Credits :  

_mixed_ `$credits` = IncandescentAPI**::getCredit** ( _null_ )

Need no parameters.  

Return `$credits` the numbers of credits remains or raw results if error.

