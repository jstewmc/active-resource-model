<?php

namespace Jstewmc\ActiveResourceModel\Tests\Api\Response;

/**
 * A concrete create request
 */
class Create extends \Jstewmc\Api\Response\Json
	implements \Jstewmc\ActiveResourceModel\Api\Response\Create
{
	public function getId()
	{
		if ($this->data) {
			if (array_key_exists('id', $this->data)) {
				return $this->data['id'];
			}
		}
		
		return null;
	}
}
