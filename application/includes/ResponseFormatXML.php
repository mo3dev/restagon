<?php
/**
 * ResponseFormatXML.php
 * 
 * 
 * PHP 5
 * 
 * @package Restagon
 * @author Mohamed Ibrahim <mo3dev@gmail.com>
 * @version 0.0.2
 * @copyright 2012, Mohamed Ibrahim
 * @licence http://opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License (BSD New)
 */


class ResponseFormatXML implements iResponseFormat
{
	
	/**
	 * extension() method returns the extension for the response format (ie 'json' for JSON format)
	 * 
	 * @return string extension for response format
	 */ 
	public function extension()
	{
		return 'xml';
	}
	
	/**
	 * contentType() method returns the HTTP Content-Type associated with the response format
	 * 
	 * @return string the HTTP Content-Type for response format
	 */ 
	public function contentType()
	{
		return 'application/xml';
	}
	
	/**
	 * getEncodedFormat() method returns encoded (serialized) response data using given raw data (ie. array)
	 * 
	 * @param array $data the data to be encoded into the response format (ie. array, etc...)
	 * @return string serialized (encoded) data to be sent back to client in the current response format
	 */ 
	public function getEncodedFormat($data)
	{
		$xmlHandler = new XmlWriter();
		
		$xmlHandler->openMemory();

		$xmlHandler->startDocument('1.0', 'UTF-8');
		$this->processXML($xmlHandler, $data);
		$xmlHandler->endElement();
		
		return $xmlHandler->outputMemory(true);
	}
	
	/**
	 * processXML() method writes the (associative) array data into the XmlWriter stream memory
	 * 
	 * @param XMLWriter $xml the XMLWriter stream (handler)
	 * @param array $data the data to be encoded into the response format (ie. array, etc...)
	 * @return string serialized (encoded) data to be sent back to client in the current response format
	 * @link http://snippets.dzone.com/posts/show/3391
	 */ 
	private function processXML(XMLWriter $xml, $data)
	{
		foreach ($data as $key => $value) {
			if ( is_array($value) ) {
				$xml->startElement($key);
				$this->processXML($xml, $value);
				$xml->endElement();
				continue;
			}
			$xml->writeElement($key, $value);
		}
	}
	
}



