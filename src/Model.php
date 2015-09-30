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
	 * @return  self
	 * @throws  BadMethodCallException  if the model has an id
	 * @throws  RuntimeException        if the api call fails
	 * @since  0.1.0
	 */
	public function create() 
	{
		// if the model has been read, short-circuit
		if (isset($this->id)) {
			throw new \BadMethodCallException(
				"You can't call create() on a model that has been read"
			);
		}
		
		$request  = $this->getCreateRequest();
		$response = $this->getCreateResponse();
		
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
	 * @return  self
	 * @throws  BadMethodCallException  if the model does not have an id
	 * @throws  RuntimeException        if the api call fails
	 * @since  0.1.0
	 */
	public function delete() 
	{
		// if the model has not been read, short-circuit
		if ( ! isset($this->id)) {
			throw new \BadMethodCallException(
				"You can't call delete() on a model that has not been read"
			);
		}
		
		$request  = $this->getDeleteRequest();
		$response = $this->getDeleteResponse():

		$this->client->send($request)->receive($response);
		
		unset($this->id);
		
		return $this;
	}
	
	/**
	 * Indexes the models
	 *
	 * @return  Jstewmc\Model\Model[]
	 * @throws  RuntimeException  if the api call fails
	 * @since  0.1.0
	 */
	public function index() 
	{
		$models = [];
		
		// get the model's request and response
		$request  = $this->getIndexRequest();
		$response = $this->getIndexResponse();
		
		// send and receive
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
	 * @return  self
	 * @throws  BadMethodCallException  if the model's id is not set
	 * @throws  RuntimeException        if the api call fails
	 * @since  0.1.0
	 */
	public function read($id) 
	{
		// if id is not a positive integer, short-circuit
		if ( ! is_numeric($id) || ! is_int(+$id) || $id < 1) {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, id, to be a positive integer"
			);	
		}
		
		$this->id = $id;
		
		$request  = $this->getReadRequest();
		$response = $this->getReadResponse();
		
		$response = $this->client->send($request)->receive($response);
		
		$this->hydrate($response->getData());
		
		return $this;
	}
	
	/**
	 * Updates the model's data
	 *
	 * @return  self
	 * @throws  BadMethodCallException  if the model does not have an id
	 * @throws  RuntimeException        if the api call fails
	 * @since  0.1.0
	 */
	public function update()
	{
		// if the model hasn't been read, short-circuit
		if ( ! isset($this->id)) {
			throw new \BadMethodCallException(
				"You can't call update() on a model that hasn't been read"
			);
		}
		
		$request  = $this->getUpdateRequest();
		$response = $this->getUpdateResponse();
		
		$request->setData($this->data);
		
		$this->client->send($request)->receive($response);
		
		return $this;
	}
	
	
	/* !Protected method */
	
	/**
	 * Returns the model's create request
	 *
	 * @return  Jstewmc\ActiveResourceModel\Api\Request\Create
	 * @since  0.1.0
	 */
	abstract protected function getCreateRequest();
	
	/**
	 * Returns the model's create response
	 *
	 * @return  Jstewmc\ActiveResourceModel\Api\Response\Create
	 * @since  0.1.0
	 */
	abstract protected function getCreateResponse();
	
	/**
	 * Returns the model's delete request
	 *
	 * @return  Jstewmc\ActiveResourceModel\Api\Request\Delete
	 * @since  0.1.0
	 */
	abstract protected function getDeleteRequest();
	
	/**
	 * Returns the model's delete response
	 *
	 * @return  Jstewmc\ActiveResourceModel\Api\Response\Delete
	 * @since  0.1.0
	 */
	abstract protected function getDeleteResponse();
	
	/**
	 * Returns the model's index request
	 *
	 * @return  Jstewmc\ActiveResourceModel\Api\Request\Index
	 * @since  0.1.0
	 */
	abstract protected function getIndexRequest();
	
	/**
	 * Returns the model's index response
	 *
	 * @return  Jstewmc\ActiveResourceModel\Api\Response\Index
	 * @since  0.1.0
	 */
	abstract protected function getIndexResponse();
	
	/**
	 * Returns the model's read request
	 *
	 * @return  Jstewmc\ActiveResourceModel\Api\Request\Read
	 * @since  0.1.0
	 */
	abstract protected function getReadRequest();
	
	/**
	 * Returns the model's read response
	 *
	 * @return  Jstewmc\ActiveResourceModel\Api\Response\Read
	 * @since  0.1.0
	 */
	abstract protected function getReadResponse();
	
	/**
	 * Returns the model's update request
	 *
	 * @return  Jstewmc\ActiveResourceModel\Api\Request\Update
	 * @since  0.1.0
	 */
	abstract protected function getUpdateRequest();
	
	/**
	 * Returns the model's update response
	 *
	 * @return  Jstewmc\ActiveResourceModel\Api\Response\Update
	 * @since  0.1.0
	 */
	abstract protected function getUpdateResponse();
}
