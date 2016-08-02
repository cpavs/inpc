<?php
namespace Cpavs\Scraping;

use DOMDocument;
use Cpavs\Scraping\HttpException;
/**
* @author Cesar Aguilera <cesar.aguilera@cpavs.mx>
* @see www.cpalumis.com.mx
* @package Inpc
* @copyright CPALUMIS 2016
*/
class Inpc
{
	protected $years;
	protected $inpcs = [];

	/**
	* @return void
	*/
	public function setYears(array $years = [])
	{
		if(!is_array($years) || count($years)==0){
			throw new InvalidArgumentException("El parametro debe ser un arreglo");
		}

		foreach($years as $year)
		{
			$this->years[] = $year;
		}

		return $this;
	}

	/**
	* @return $this
	* @throws HttpException
	*/
	public function execute()
	{

		foreach($this->years as $year)
		{
			$response = file_get_contents("http://www.finanzas.df.gob.mx/servicios/capaInpc.php?&anio%5B%5D={$year}&btnINPC=Ver%20tabla");
			
			if(!$response){
				throw new HttpException("Error al recibir el origen de los datos, intente mas tarde.");
			}

			$this->parseArray($response,$year);
		}

		return $this;
	}

	/**
	* @return void
	*/
	protected function parseArray($str,$year)
	{
		$DOM = new DOMDocument;
	    $DOM->loadHTML($str);
	    $items = $DOM->getElementsByTagName('tr');
	    $index = 0;
	    foreach ($items as $node)
	    {
	        if($index>0){
	        	$parts = preg_split("/[\s,]+/",$node->nodeValue);
	        	$i = 1;
	        	foreach($parts as $part)
	        	{
	        		if(!empty($part) && $part!=$year){
	        			$this->inpcs[$year][$i] = $part;
	        			$i++;
	        		}	        		
	        	}
	        }
	        $index++;
	    }
	}

	/**
	* @return Object
	*/

	public function get()
	{
		return $this->inpcs;
	}
}