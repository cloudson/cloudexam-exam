<?php

namespace CloudExam\Exam\Repository;

trait Hydrate
{
	public function asTransfer($entity)
	{
		$entityName = get_class($entity);
		$transferName = str_replace("Entity", "Transfer", $entityName);

		
		$transfer = new $transferName;
		$reflect = new \ReflectionClass($transfer);
		$properties = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED);
		foreach ($properties as $property) {
			$setter = 'set' . ucfirst($property->getName());
			$getter = 'get' . ucfirst($property->getName());
			if (method_exists($entity, $getter) && method_exists($transfer, $setter)) {
				$transfer->$setter($entity->$getter());
			}
		}

		return $transfer;
	}
}