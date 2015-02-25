<?php 

namespace CloudExam\Exam\Transfer;

class Exam 
{
    public $name; 
    public $slug;

    public function setName($name)
    {
        $this->name = $name; 
    }

    public function getName()
    {
        return $this->name; 
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
         return $this->slug;
    }
}
