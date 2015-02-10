<?php

namespace CloudExam\Exam\Entity;

/**
 * @ORM\Entity(repositoryClass="\CloudExam\Exam\Repository\Exam")
 * 
 */ 
class Exam
{
   protected $name; 

   public function  setName($name)
   {
        $this->name = $name; 
   }

   public function getName()
   {
        return $this->name; 
   }
}
