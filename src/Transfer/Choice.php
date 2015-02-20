<?php 

namespace CloudExam\Exam\Transfer;

class Choice 
{
   protected $title; 

   public function setTitle($title)
   {
        $this->title = $title; 
   }

   public function getTitle()
   {
   		return $this->title;
   }
}
