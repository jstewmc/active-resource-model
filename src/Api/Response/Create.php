<?php

namespace Jstewmc\ActiveResourceModel\Api\Response;

/**
 * A create response interface
 *
 * A create response should include the entity's new id.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
interface Create implements Request
{
	/* !Public methods */
	
	/**
	 * Gets the entity's id
	 *
	 * @return  int  the entity's id
	 * @since  0.1.0
	 */
	public function getId();
}