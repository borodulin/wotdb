<?php

function HandleXmlError($errno, $errstr, $errfile, $errline)
{
	if ($errno==E_WARNING && (substr_count($errstr,"DOMDocument::loadXML()")>0))
	{
		throw new DOMException($errstr);
	}
	else
		return false;
}


class XmlPath
{
	private $_doc;
	private $_xpath;
	
	
	public function __construct($xml)
	{
	//	$xml = preg_replace('/&QUOT;?/', '', $xml);
	//	$xml = preg_replace('/&/', '', $xml);
	//	file_put_contents(Yii::app()->getRuntimePath().'/tt/last.xml', $xml);
		$this->_doc=new DOMDocument();
		$this->_doc->recover = true;
		$this->_doc->strictErrorChecking = false;
		libxml_use_internal_errors(true);
		set_error_handler('HandleXmlError');
		$this->_doc->loadHTML($xml);
		restore_error_handler();
		$this->_xpath = new DOMXpath($this->_doc);
	}
	
	/**
	 * 
	 * @return DOMXpath
	 */
	public function getXPath()
	{
		return $this->_xpath;
	}
	
	/**
	 * 
	 * @return DOMDocument
	 */
	public function getDoc()
	{
		return $this->_doc;
	}
	
	public static function isAssociative($array)
	{
		return !empty($array)&&(array_keys($array) !== range(0, count($array) - 1));
	}
	
	/**
	 * 
	 * @param DOMNodeList $elements
	 * @return multitype:multitype:NULL
	 */
	protected function xmlToArray($elements)
	{
		if($elements instanceof DOMNodeList){
			if($elements->length==1)
				return $this->xmlToArray($elements->item(0));
			else
			{
				$result=array();
				foreach ($elements as $element){
					$result[]=$this->xmlToArray($element);
				}
				return $result;
			}
		}
		elseif($elements instanceof DOMNode){
			if($elements->hasChildNodes()){
				$result=array();
				foreach ($elements->childNodes as $element){
					if($element->nodeType!=3){
						if(isset($result[$element->nodeName])){
							if(is_array($result[$element->nodeName])&& !self::isAssociative($result[$element->nodeName]))
								$result[$element->nodeName][]=$this->xmlToArray($element);
							else{
								$v=$result[$element->nodeName];
								$result[$element->nodeName]=array();
								$result[$element->nodeName][]=$v;
								$result[$element->nodeName][]=$this->xmlToArray($element);
							}
						}
						else
							$result[$element->nodeName]=$this->xmlToArray($element);
						
					}
				}
				if(count($result)==0)
					return $elements->nodeValue;
				else
					return $result;
			}
			else{
				return $elements->nodeValue;
			}
		}
	} 
	
	/**
	 * 
	 * @param array() $paths
	 * @return array()
	 */
	public function queryAll($paths)
	{
		$result=array();
		foreach ($paths as $name=>$path){
			$elements=$this->_xpath->query($path);
			$result[$name]=$this->xmlToArray($elements);
		}
		return $result;
	}
	
	
	public function registerNamespace($prefix, $namespaceURI)
	{
		$this->_xpath->registerNamespace($prefix, $namespaceURI);
	}
}