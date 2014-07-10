<?php

class CUrlHelper
{

	private static $defaultOptions=array(
		CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION =>  true,
		CURLOPT_AUTOREFERER => true,
		CURLOPT_MAXREDIRS => 3,
		CURLOPT_CONNECTTIMEOUT => 30,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_TIMEOUT => 30,
	);
	
	public $content;

	public $errorCode;

	public $errorMessage;

	public $httpCode;

	public $totalTime;

	public function isHttpOK()
	{
		return (strncmp($this->httpCode,'2',1)==0);
	}

	public function execute($url, $options=array(), $postData=array())
	{
		$ch = curl_init();
			
		$options=CMap::mergeArray(self::$defaultOptions, $options);
		$options[CURLOPT_URL]=$url;
	
	
		if(!empty($postData)){
			$options[CURLOPT_POST]=true;
			$options[CURLOPT_POSTFIELDS]=$postData;
		}
		
		foreach ($options as $key=>$value){
			curl_setopt($ch, $key, $value);
		}
		$start = microtime(true);
		// загрузка страницы и выдача её браузеру
		$this->content=curl_exec($ch);
	
		$this->totalTime=microtime(true)-$start;
	
		$this->errorCode=curl_errno($ch);
	
		if($this->errorCode)
		{
			$this->errorMessage = curl_error($ch);
		}
	
		$this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		// завершение сеанса и освобождение ресурсов
		curl_close($ch);
				
		if($this->errorCode)
			return false;
		else if(!$this->isHttpOK()){
			$this->errorMessage=$this->content;
			return false;
		}
		else
			return true; 
	}
}
