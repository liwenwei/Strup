<?php

class mycurl {
	protected $_useragent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1';
	protected $_url;
	protected $_followlocation;
	protected $_timeout;
	protected $_maxRedirects;
	protected $_cookieFileLocation = './cookie.txt';
	protected $_post;
	protected $_postFields;
	protected $_referer = "http://www.google.com";
	
	protected $_session;
	protected $_webpage;
	protected $_includeHeader;
	protected $_noBody;
	protected $_status;
	protected $_binaryTransfer;
	public $authentication = 0;
	public $auth_name      = '';
	public $auth_pass      = '';
	
	
    public function __construct($url, $followlocation = true, $timeout = 30, $maxRedirects = 4,
$binaryTransfer = false, $includeHeader = false, $noBody = false)
    {
    	$this->_url = $url;
    	$this->_followlocation = $followlocation;
    	$this->_timeout = $timeout;
    	$this->_maxRedirects = $maxRedirects;
    	$this->_noBody = $noBody;
    	$this->_includeHeader = $includeHeader;
    	$this->_binaryTransfer = $binaryTransfer;
    	
    	$this->_cookieFileLocation = dirname(__FILE__).'/cookie.txt';
    	
    }
    
    public function useAuth($use){
    	$this->authentication = 0;
    	if($use == true) $this->authentication = 1;
    }
    
    public function setName($name){
    	$this->auth_name = $name;
    }
    
    public function setPass($pass){
    	$this->auth_pass = $pass;
    }
    
    public function setReferer($referer){
    	$this->_referer = $referer;
    }
    
    public function setCookiFileLocation($path){
    	$this->_cookieFileLocation = $path;
    }
    
    public function setPost ($postFields){
    	$this->_post = true;
    	$this->_postFields = $postFields;
    }
    
    public function setUserAgent($userAgent){
    	$this->_useragent = $userAgent;
    }
    
    public function createCurl($url = 'nul'){
    	if($url != 'nul'){
    		$this->_url = $url;
    	}
    	
    	// Initiate curl
    	$ch = curl_init();
    	
    	$header = array();
    	$header[] = 'Accept: application/json';
    	$header[] = 'X-Request: JSON';
    	$header[] = 'X-Requested-With: XMLHttpRequest';
    	
    	/************************************
    	 * 
    	 * TODO: Learn more about the http header
    	 * 
    	 **********************************/
        /* $header[] = 'Accept-Encoding: gzip, deflate, sdch';
        $header[] = 'Accept-Language: zh-CN,zh;q=0.8';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Cookie: sid=degsfnZpb0zZasKaJXuT2ogT.y5DrPd0n%2F1flfouGNkdAJyoG2fG9AsVfySSnJAs%2B5%2F0';
        $header[] = 'Host: huaban.com';
        $header[] = 'Referer: http://huaban.com/favorite/beauty/';
        $header[] = 'X-Request: JSON';
        $header[] = 'X-Requested-With: XMLHttpRequest'; */
    	
    	curl_setopt($ch, CURLOPT_URL, $this->_url);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification
    	curl_setopt($ch, CURLOPT_HEADER, 0);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    	curl_setopt($ch, CURLOPT_NOBODY, 0);
    	curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);
    	curl_setopt($ch, CURLOPT_MAXREDIRS, $this->_maxRedirects);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $this->_followlocation);
    	curl_setopt($ch, CURLOPT_COOKIEJAR, $this->_cookieFileLocation);
    	curl_setopt($ch, CURLOPT_COOKIEFILE, $this->_cookieFileLocation);
    	curl_setopt($ch, CURLOPT_USERAGENT, $this->_useragent);
    	curl_setopt($ch, CURLOPT_REFERER, $this->_referer);
    	
    	if($this->authentication == 1){
    		curl_setopt($ch, CURLOPT_USERPWD, $this->auth_name.':'.$this->auth_pass);
    	}
    	
    	if($this->_post){
    		curl_setopt($ch, CURLOPT_POST, true);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_postFields);
    	}
    	
    	if($this->_includeHeader){
    		curl_setopt($ch, CURLOPT_HEADER, true);
    	}
    	
    	if($this->_noBody)
    	{
    		curl_setopt($ch,CURLOPT_NOBODY,true);
    	}
    	/*
    	 if($this->_binary)
    	 {
    	curl_setopt($s,CURLOPT_BINARYTRANSFER,true);
    	}
    	*/
    	
    	$this->_webpage = curl_exec($ch);
    	$this->_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    	
    	curl_close($ch);
    }
    
    public function getHttpStatus(){
    	return $this->_status;
    }
    
    public function __tostring(){
    	return $this->_webpage;
    }
    
}

?>