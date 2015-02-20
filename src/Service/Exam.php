<?php

namespace CloudExam\Exam\Service; 


use CloudExam\Exam\Repository\Exam as ExamRepository;
use CloudExam\Exam\Entity\Exam as ExamEntity;
use CloudExam\Exam\Transfer\Exam as ExamTransfer;
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
       $entity =  $this->examRepo->findBySlug($slug); 
       if (is_null($entity)) {
           return null;
       } 

       return $this->asTransfer($entity); 
   }

   public function getAll(Array $criteria)
   {
      $collection = $this->examRepo->findLast($criteria);
      $result = [];
      foreach ($collection as $item) {
          $result[] = $this->asTransfer($item);
      }

      return $result;
   }

   protected function asTransfer(ExamEntity $exam) 
   {
       $transfer = new ExamTransfer();
       $transfer->setName($exam->getName());

       return $transfer;
   }
}
