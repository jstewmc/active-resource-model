<?php
	
namespace Jstewmc\ActiveResourceModel\Tests;

/**
 * Tests for the Model class
 *
 * Keep in mind, I (Jack) did a few things differently here:
 * 
 *     - Because the library defines interfaces, not concreate classes, I had to
 *       define the concrete classes.
 *     - As a result, tests are in their own namespace, not the library's main 
 *       namespace. 
 *     - Because I define the output each request will give me, I know exactly 
 *       what I should expect (see the Model class for details).
 */
class ModelTest extends \PHPUnit_Framework_TestCase
{
	/* !create() */
	
	/**
	 * create() should throw a BadMethodCallException if the model does have id
	 */
	public function test_create_throwsBadMethodCallException_ifModelDoesHaveId()
	{
		$this->setExpectedException('BadMethodCallException');
		
		$client = new Api\Client();
		
		$model = new Model($client);
		$model->id = 1;
		$model->foo = 'bar';
		
		$model->create();
		
		return;
	}
	
	/**
	 * create() should set the model's id and return self if model does not have id
	 */
	public function test_create_returnsSelf_ifModelDoesNotHaveId()
	{
		$client = new Api\Client();
		
		$model = new Model($client);
		$model->foo = 'bar';
		
		$model->create();
	
		$this->assertEquals(1, $model->id);
		
		return;
	}
	
	
	/* !delete() */
	
	/**
	 * delete() should throw BadMethodCallException if model does not have id
	 */
	public function test_delete_throwsBadMethodCallException_ifModelDoesNotHaveId()
	{
		$this->setExpectedException('BadMethodCallException');
		
		$client = new Api\Client();
		
		$model = new Model($client);
		$model->delete();
		
		return;
	}
	
	/**
	 * delete() should return self if model does have id
	 */
	public function test_delete_returnsSelf_ifModelDoesHaveId()
	{
		$client = new Api\Client();
		
		$model = new Model($client);
		$model->id = 1;
		
		$model->delete();
		
		$this->assertNull($model->id);
		
		return;
	}
	
	
	/* !index() */
	
	/**
	 * index() should return an array if entities exist
	 */
	public function test_index_returnsArray()
	{
		$client = new Api\Client();
		
		$model = new Model($client);
		
		$model1 = new Model($client);
		$model1->id = 1;
		$model1->foo = 'bar';
		
		$model2 = new Model($client);
		$model2->id = 2;
		$model2->foo = 'baz';
		
		$this->assertEquals([$model1, $model2], $model->index());
		
		return;
	}
	
	
	/* !read() */
	
	/**
	 * read() should throw InvalidArgumentException if $id is not a positive int
	 */
	public function test_read_throwsInvalidArgumentException_ifIdIsNotPositiveInt()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		(new Model(new Api\Client()))->read('foo');
		
		return;
	}
	
	/**
	 * read() should return self if id is a positive int
	 */
	public function test_read_returnsSelf_ifIdIsPositiveInt()
	{
		$client = new Api\Client();
		
		$model = new Model($client);
		
		$this->assertSame($model, $model->read(1));
		
		return;
	}
	
	
	/* !update() */	

	/**
	 * update() should throw BadMethodCallException if the model does not have id
	 */
	public function test_update_throwsBadMethodCallException_ifModelDoesNotHaveId()
	{
		$this->setExpectedException('BadMethodCallException');
		
		(new Model(new Api\Client()))->update();
		
		return;
	}
	
	/**
	 * update() should return self if the model does have id
	 */
	public function test_update_returnsSelf_ifModelDoesHaveId()
	{
		$client = new Api\Client();
		
		$model = new Model($client);
		$model->id = 1;
		
		$model->update();
		
		$this->assertSame($model, $model->update());
		
		return;
	}
}
