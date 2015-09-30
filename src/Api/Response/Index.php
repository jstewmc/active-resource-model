<?php

namespace Jstewmc\ActiveResourceModel\Api\Response;

/**
 * An index response interface
 *
 * An index response should include an array of entities.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
interface Index implements Request
{
	/* !Public methods */
	
	/**
	 * Gets the response's entities
	 *
	 * @return  mixed[]  an array of arrays with entity data
	 * @since  0.1.0
	 */
	public function getEntities();
}