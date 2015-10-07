<?php

namespace Jstewmc\ActiveResourceModel\Tests\Api\Response;

/**
 * A concrete index request
 */
class Index extends \Jstewmc\Api\Response\Json
	implements \Jstewmc\ActiveResourceModel\Api\Response\Index
{
	public function getEntities()
	{
		if ($this->data) {
			if (array_key_exists('entities', $this->data)) {
				return $this->data['entities'];
			}
		}
		
		return [];
	}
}
