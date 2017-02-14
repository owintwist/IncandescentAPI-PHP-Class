<?php	class IncandescentAPI {
	
	/***
	 * 
	 *	IncandescentAPI PHP Class v0.2
	 *	https://github.com/owintwist/IncandescentAPI-PHP-Class
	 * 
	 ***/

	/// Configuration
	const UID = '';			// Your API UID
	const KEY = '';			// Your API KEY
	const EXPIRES = 300;	// Default auth expiration delay
	const FILTERSDIR = '.';	// Filters' dir without ending "/"
	

	public static function addImage($images,$c=1) {
		if (!is_array($images)) $images = array($images);
		$r = self::sendRequest(array("images" => $images,"multiple" => $c),'add');
		if (isset($r->status) AND $r->status == 201 AND isset($r->project_id)) return $r->project_id;
		return $r;
	}

	public static function getResults($project_id) {
		$r = self::sendRequest(array("project_id" => $project_id),'get');
		if (isset($r->status) AND $r->status == 755) return false;
		return $r;
	}
		
	public static function getMergedResults($proj=array(),$or='domain') {
		if (!is_array($proj)) $proj = array($proj);
		foreach ($proj as $pr) {
			if ($a = self::getResults($pr)) foreach ($a as $domain => $d) {
				if ($d->pages AND !self::isFiltered($domain)) foreach ($d->pages as $entry) {
					$entry = (array) $entry;
					if (!self::isFiltered($domain,$entry['usage-image'])) {
						if ($or == 'domain') $res[$domain][] = $entry;
						else if ($or == 'image') $res[$entry['image']][] = $entry;
					}
				}
			}
		}
		ksort($res);
		return $res;
	}
	
	public static function getCredits() {
		$r = self::sendRequest([],'credit');
		if (isset($r->status) AND $r->status == 200) return $r->credit;
		return $r;
	}
	
	private function isFiltered($domain,$img=false) {
		if (!file_exists(self::FILTERSDIR)) mkdir(self::FILTERSDIR);
		if (!file_exists(self::FILTERSDIR.'/domains-ignore.json')) file_put_contents(self::FILTERSDIR.'/domains-ignore.json','{}');
		if (!file_exists(self::FILTERSDIR.'/not-match.json')) file_put_contents(self::FILTERSDIR.'/not-match.json','{}');
		if (in_array($domain,(array) json_decode(file_get_contents(self::FILTERSDIR.'/domains-ignore.json')))) return true;
		if ($img AND in_array($img,(array) json_decode(file_get_contents(self::FILTERSDIR.'/not-match.json')))) return true;
		return false;
	}
	
	private function sendRequest($data,$t,$expires=self::EXPIRES) {
		$expires = time()+$expires;
		$h = self::UID."-".$expires."-".self::KEY; 
		$auth = md5($h);
		$data = array_merge(array("uid"=>self::UID,"expires"=>$expires,"auth"=>$auth),$data);
		$json = json_encode($data);
		$context = stream_context_create(array(
			'http' => array(
				'method' => 'POST', 
				'header' => "Content-Type: application/json\r\nUser-Agent: IncandescentAPI PHP Class/0.2\r\n",
				'content' => $json 
			)
		));
		$response = file_get_contents("https://incandescent.xyz/api/$t/", FALSE, $context);
		return json_decode($response);
	}

}
