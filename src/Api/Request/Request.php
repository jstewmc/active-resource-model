<?php

namespace Jstewmc\ActiveResourceModel\Api\Request;

/**
 * An API request interface
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
interface Request
{
	/* !Public methods */
	
	/**
	 * Sets the request's data
	 *
	 * @param  mixed[]  $data  the request's data
	 * @return  self
	 * @since  0.1.0
	 */
	public function setData(Array $data);
}