<?php
require_once 'Customizing/global/plugins/Services/Repository/RepositoryObject/InteractiveVideo/classes/class.ilInteractiveVideoXMLParser.php';

/**
 * Class ilInteractiveVideoFauXMLParser
 */
class ilInteractiveVideoFauXMLParser extends ilInteractiveVideoXMLParser
{
	/**
	 * @var ilInteractiveVideoFauVideoPortal
	 */
	protected $fau_obj;
	

	/**
	 * @param ilInteractiveVideoFauVideoPortal $youtube_obj
	 * @param                      $xmlFile
	 */
	public function __construct($fau_obj, $xmlFile)
	{
		$this->fau_obj = $fau_obj;
		$this->setHandlers($xmlFile);
	}

	/**
	 * @param $xmlParser
	 * @param $tagName
	 * @param $tagAttributes
	 */
	public function handlerBeginTag($xmlParser, $tagName, $tagAttributes)
	{
		switch($tagName)
		{
			case 'FauId':
			case 'FauURL':
			case 'VideoSourceObject':
				$this->cdata = '';
				break;
		}
	}

	/**
	 * @param $xmlParser
	 * @param $tagName
	 */
	public function handlerEndTag($xmlParser, $tagName)
	{
		switch($tagName)
		{
			case 'FauId':
				$this->fau_obj->setFauId(trim($this->cdata));
				break;			
			case 'FauURL':
				$this->fau_obj->setFauUrl(trim($this->cdata));
				break;
			case 'VideoSourceObject':
				$tmp = $this->cdata;
				break;
		}
	}

	private function fetchAttribute($attributes, $name)
	{
		if( isset($attributes[$name]) )
		{
			return $attributes[$name];
		}
		return null;
	}

	/**
	 * @param $xmlParser
	 */
	public function setHandlers($xmlParser)
	{
		xml_set_object($xmlParser, $this);
		xml_set_element_handler($xmlParser, 'handlerBeginTag', 'handlerEndTag');
		xml_set_character_data_handler($xmlParser, 'handlerCharacterData');
	}

}