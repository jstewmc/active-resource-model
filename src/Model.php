<?php

namespace Jstewmc\ActiveResourceModel;

/**
 * An active resource model
 *
 * An active resource model uses an API to perform simple CRUD operations.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
abstract class Model extends \Jstewmc\Model\Model
{
	/* !Protected properties */
	
	/**
	 * @var  Jstewmc\ActiveResourceModel\Api\Client  the model's API client
	 * @since  0.1.0
	 */
	protected $client;
	
	
	/* !Magic methods */
	
	/**
	 * Called when the model is constructed
	 *
	 * @param  Jstewmc\ActiveResourceModel\Api\Client  $client  the API client to use
	 * @return  self
	 * @since  0.1.0
	 */
	public function __construct(Api\Client $client)
	{	
		$this->client = $client;
		
		return;
	}
	
	/**
	 * Called when the model is destructed
	 *
	 * I make sure the API client is destructed, and in turn, that any request and
	 * connection resources are cleaned up.
	 *
	 * @return  void
	 * @since  0.1.0
	 */ 
	public function __destruct()
	{
		unset($this->client);
		
		return;
	}
	
	
	/* !Public methods */
	
	/**
	 * Create a new model
	 *
	 * I'll set the model's id property if successful.
	 *
	 * @param  Jstewmc\ActiveResourceModel\Api\Request\Create  $request  the create 
	 *     request to send
	 * @param  Jstewmc\ActiveResourceModel\Api\Response\Create  $response  the create 
	 *     response to receive
	 * @return  self
	 * @throws  BadMethodCallException  if the model has an id
	 * @throws  RuntimeException        if the api call fails
	 * @since  0.1.0
	 */
	public function create(Api\Request\Create $request, Api\Response\Create $response) 
	{
		// if the model has been read, short-circuit
		if (isset($this->id)) {
			throw new \BadMethodCallException(
				"You can't call create() on a model that has been read"
			);
		}
		
		$request->setData($this->data);
		
		$response = $this->client->send($request)->receive($response);
		
		$this->id = $response->getId();
		
		return $this;
	}
	
	/**
	 * Deletes an existing model
	 *
	 * On success, I'll set the model's id to null.
	 *
	 * @param  Jstewmc\ActiveResourceModel\Api\Request\Delete  $request  the delete 
	 *     request to send
	 * @param  Jstewmc\ActiveResourceModel\Api\Response\Create  $response  the delete 
	 *     response to receive
	 * @return  self
	 * @throws  BadMethodCallException  if the model does not have an id
	 * @throws  RuntimeException        if the api call fails
	 * @since  0.1.0
	 */
	public function delete(Api\Request\Delete $request, Api\Response\Delete $response) 
	{
		// if the model has not been read, short-circuit
		if ( ! isset($this->id)) {
			throw new \BadMethodCallException(
				"You can't call delete() on a model that has not been read"
			);
		}

		$this->client->send($request)->receive($response);
		
		unset($this->id);
		
		return $this;
	}
	
	/**
	 * Indexes the models
	 *
	 * @param  Jstewmc\ActiveResourceModel\Api\Request\Create  $request  the index
	 *     request to send
	 * @param  Jstewmc\ActiveResourceModel\Api\Response\Create  $response  the index 
	 *     response to receive
	 * @return  Jstewmc\Model\Model[]
	 * @throws  RuntimeException  if the api call fails
	 * @since  0.1.0
	 */
	public function index(Api\Request\Index $request, Api\Response\Index $response) 
	{
		$models = [];
		
		$response = $this->client->send($request)->receive($response);
		
		// get the called class' classname
		$classname = get_class($this);
		
		// loop through the response's entities
		foreach ($response->getEntities() as $data) {
			// create and append a new model
			$models[] = (new $classname($this->client))->hydrate($data); 
		}
		
		return $models;
	}
	
	/**
	 * Reads a model
	 *
	 * @param  Jstewmc\ActiveResourceModel\Api\Request\Read  $request  the read 
	 *     request to send
	 * @param  Jstewmc\ActiveResourceModel\Api\Response\Read  $response  the read 
	 *     response to receive
	 * @return  self
	 * @throws  BadMethodCallException  if the model's id is not set
	 * @throws  RuntimeException        if the api call fails
	 * @since  0.1.0
	 */
	public function read(Api\Request\Read $request, Api\Response\Read $response) 
	{
		// if the model doesn't have an id, short-circuit
		if ( ! isset($this->id)) {
			throw new \BadMethodCallException(
				"You can't call read() on a model that doesn't have an id"
			);
		}
		
		$response = $this->client->send($request)->receive($response);
		
		// set the model's data
		$this->hydrate($response->getData());
		
		return $this;
	}
	
	/**
	 * Updates the model's data
	 *
	 * @param  Jstewmc\ActiveResourceModel\Api\Request\Update  $request  the update 
	 *     request to send
	 * @param  Jstewmc\ActiveResourceModel\Api\Response\Update  $response  the update 
	 *     response to receive
	 * @return  self
	 * @throws  BadMethodCallException  if the model does not have an id
	 * @throws  RuntimeException        if the api call fails
	 * @since  0.1.0
	 */
	public function update(Api\Request\Update $request, Api\Response\Update $response)
	{
		// if the model hasn't been read, short-circuit
		if ( ! isset($this->id)) {
			throw new \BadMethodCallException(
				"You can't call update() on a model that hasn't been read"
			);
		}
		
		$request->setData($this->data);
		
		$this->client->send($request)->receive($response);
		
		return $this;
	}
}
