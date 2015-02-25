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
		$properties = $reflect->getProperties();
		foreach ($properties as $property) {
			$setter = 'set' . ucfirst($property);
			$getter = 'get' . ucfirst($property);
			if (method_exists($entity, $getter) && method_exists($transfer, $setter)) {
				$transfer->$setter($entity->$getter());
			}
		}

		return $transfer;
	}
}