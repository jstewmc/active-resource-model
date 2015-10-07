<?php

namespace Jstewmc\ActiveResourceModel\Tests\Api\Response;

/**
 * A concrete read request
 */
class Read extends \Jstewmc\Api\Response\Json
	implements \Jstewmc\ActiveResourceModel\Api\Response\Read
{
	public function getAttributes()
	{
		if ($this->data) {
			return $this->data;
		}
		
		return [];
	}
}
