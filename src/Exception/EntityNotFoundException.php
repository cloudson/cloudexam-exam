<?php

namespace CloudExam\Exam\Exception;

class EntityNotFoundException extends \BadMethodCallException
{

	private $entityName; 
	private $byField; 
	private $fieldValue;

	public function __construct($entityName, Array $byValues)
	{
		parent::__construct(sprintf(
			"Entity '%s' not found with [%s]", $entityName, $this->getByStringMap($byValues)
		));
	}

	private function getByStringMap($byValues)
	{
		$string = array();
		foreach ($byValues as $field => $value ) {
			$string[] = sprintf("%s = %s", $field, $value);
		}

		return implode(',', $string);
	}

	public function getEntityName()
	{
		return $this->entityName;
	}

	public function getByField()
	{
		return $this->byField;
	}

	public function getFieldValue()
	{
		return $this->fieldValue;
	}


}