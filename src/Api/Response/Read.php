<?php

namespace Jstewmc\ActiveResourceModel\Api\Response;

/**
 * A read response interface
 * 
 * A read response should include an array of the entity's data.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
interface Read implements Request
{
	/* !Public methods */
	
	/**
	 * Gets the entity's attributes
	 *
	 * @return  mixed[]  
	 * @since  0.1.0
	 */
	public function getAttributes();
}