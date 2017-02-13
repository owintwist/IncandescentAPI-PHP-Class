<?php	class IncandescentAPI {
	
	/***
	 * 
	 *	IncandescentAPI PHP Class v0.1
	 *	https://github.com/owintwist/IncandescentAPI-PHP-Class
	 * 
	 ***/

	/// Configuration
	const UID = '';			// Your API UID
	const KEY = '';			// Your API KEY
	const EXPIRES = 300;	// Default auth expiration delay
	

	public static function addImage($images,$c=1) {
		if (!is_array($images)) $images = array($images);
		$r = self::sendRequest(array("images" => $images,"multiple" => $c),'add');
		if ($r->status == 201 AND isset($r->project_id)) return $r->project_id;
		return $r;
	}

	public static function getImage($project_id) {
		$r = self::sendRequest(array("project_id" => $project_id),'get');
		if ($r->status == 755) return false;
		return $r;
	}
	
	public static function getCredits() {
		$r = self::sendRequest([],'credit');
		if ($r->status == 200) return $r->credit;
		return $r;
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
				'header' => "Content-Type: application/json\r\nUser-Agent: IncandescentAPI PHP Class/0.1\r\n",
				'content' => $json 
			)
		));
		$response = file_get_contents("https://incandescent.xyz/api/$t/", FALSE, $context);
		return json_decode($response);
	}

}
