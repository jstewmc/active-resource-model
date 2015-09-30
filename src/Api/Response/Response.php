<?php

namespace Jstewmc\ActiveResourceModel\Api\Response;

/**
 * A response interface
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
interface Response
{
	/* !Public methods */
	
	/**
	 * Gets the response's original data
	 *
	 * @return  mixed[]
	 * @since  0.1.0
	 */
	public function getData();
}