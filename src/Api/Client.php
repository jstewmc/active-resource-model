<?php

namespace Jstewmc\ActiveResourceModel\Api;

/**
 * An interface for the model's api client
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
interface Client 
{
	/* !Public methods */
	
	/**
	 * Receives the service's response
	 *
	 * @param  Jstewmc\ActiveResourceModel\Api\Response\Response  $response  the 
	 *     response to receive
	 * @return  Jstewmc\ActiveResourceModel\Api\Response\Response 
	 * @since  0.1.0
	 */
	public function receive($response);
	
	/**
	 * Executes the request
	 *
	 * @param  Jstewmc\ActiveResourceModel\Api\Request\Request  $request  the request 
	 *     to send
	 * @return  self
	 * @since  0.1.0
	 */
	public function send($request);
}
