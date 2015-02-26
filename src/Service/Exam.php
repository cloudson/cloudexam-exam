<?php

namespace CloudExam\Exam\Service; 

use CloudExam\Exam\Repository\Exam as ExamRepository;
use CloudExam\Exam\Entity\Exam as ExamEntity;

class Exam
{
   protected $examRepo;

   public function __construct(ExamRepository $examRepo) 
   {
       $this->examRepo = $examRepo; 
   }

   /**
    * @method \CloudExam\Exam\Entity\Exam findBySlug
    */ 
   public function get($slug)
   {
       $entity =  $this->examRepo->findOneBySlug($slug); 
       if ($entity === null) {
           return null;
       } 
       return $this->examRepo->asTransfer($entity); 
   }

   public function getAll(Array $criteria)
   {
      $collection = $this->examRepo->findLast($criteria);
      $result = [];
      foreach ($collection as $item) {
          $result[] = $this->examRepo->asTransfer($item);
      }

      return $result;
   }
}
