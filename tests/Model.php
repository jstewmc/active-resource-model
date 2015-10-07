<?php
	
namespace Jstewmc\ActiveResourceModel\Tests;

/**
 * A concrete model class
 */
class Model extends \Jstewmc\ActiveResourceModel\Model
{	
	/* !Protected properties */
	
	/**
	 * @var  string[]  an array of model properties
	 */
	protected static $properties = ['id', 'foo'];
	
	
	/* !Protected methods */
	
	/** 
	 * Returns the model's base url
	 *
	 * The unit tests use the Jstewmc\ApiTester repository.
	 *
	 * @return  Jstewmc\Url\Url
	 * @see     https://github.com/jstewmc/api-tester
	 */
	protected function url()
	{
		return new \Jstewmc\Url\Url('http://localhost:8000');
	}
	
	/**
	 * Returns the model's create request
	 *
	 * A create request should output an id.
	 *
	 * @return  Jstewmc\ActiveResourceModel\Tests\Api\Request\Create
	 */
	protected function getCreateRequest()
	{
		$url = $this->url();
		
		$url
			->getQuery()
				->setParameter('code', 200)
				->setParameter('format', 'json')
				->setParameter('output', '{"id": 1}');
			
		return new Api\Request\Create((string) $url);
	}	
	
	/**
	 * Returns the model's create response
	 *
	 * @return  Jstewmc\ActiveResourceModel\Tests\Api\Response\Create
	 */
	protected function getCreateResponse()
	{
		return new Api\Response\Create();	
	}
	
	/**
	 * Returns the model's delete request
	 *
	 * A delete request should return the HTTP status code 204 (i.e., no content).
	 *
	 * @return  Jstewmc\ActiveResourceModel\Tests\Api\Request\Delete
	 */
	protected function getDeleteRequest()
	{
		$url = $this->url();
		
		$url->getQuery()->setParameter('code', 204);
		
		return new Api\Request\Create((string) $url);
	}
	
	/**
	 * Returns the model's delete response
	 *
	 * @return  Jstewmc\ActiveResourceModel\Tests\Api\Response\Delete
	 */
	protected function getDeleteResponse()
	{
		return new Api\Response\Delete();
	}
	
	/**
	 * Returns the model's index request
	 *
	 * An index request should output an array of "entities". Our entities have the
	 * attributes "id" and "foo".
	 * 
	 * @return  Jstewmc\ActiveResourceModel\Tests\Api\Request\Index
	 */
	protected function getIndexRequest()
	{
		$url = $this->url();
	
		$url
			->getQuery()
				->setParameter('code', 200)
				->setParameter('format', 'json')
				->setParameter(
					'output', 
					'{"entities":[{"id":1,"foo":"bar"},{"id":2,"foo":"baz"}]}'
				);
				
		return new Api\Request\Index((string) $url);
	}
	
	/**
	 * Returns the model's index response
	 *
	 * @return  Jstewmc\ActiveResourceModel\Tests\Api\Response\Index
	 */
	protected function getIndexResponse()
	{
		return new Api\Response\Index();
	}
	
	/**
	 * Returns the model's read request
	 *
	 * A read request should output the model's "id" and "foo" attributes.
	 *
	 * @return  Jstewmc\ActiveResourceModel\Tests\Api\Request\Read
	 */
	protected function getReadRequest()
	{
		$url = $this->url();
	
		$url
			->getQuery()
				->setParameter('code', 200)
				->setParameter('format', 'json')
				->setParameter('output', '{"id":1, "foo":"bar"}');
		
		return new Api\Request\Read((string) $url);
	}
	
	/**
	 * Returns the model's read response
	 *
	 * @return  Jstewmc\ActiveResourceModel\Tests\Api\Response\Read
	 */
	protected function getReadResponse()
	{
		return new Api\Response\Read();
	}
	
	/**
	 * Returns the model's update request
	 *
	 * An update request should return status code 200.
	 *
	 * @return  Jstewmc\ActiveResourceModel\Tests\Api\Request\Update
	 */
	protected function getUpdateRequest()
	{
		$url = $this->url();
	
		$url->getQuery()->setParameter('code', 200);
		
		return new Api\Request\Update((string) $url);
	}
	
	/**
	 * Returns the model's update response
	 *
	 * @return  Jstewmc\ActiveResourceModel\Tests\Api\Response\Update
	 */
	protected function getUpdateResponse()
	{
		return new Api\Response\Update();
	}
}
