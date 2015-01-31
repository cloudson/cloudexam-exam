<?php 

namespace CloudExam\Exam\Transfer;

class Exam 
{
    protected $name; 
    protected $slug;

    public function setName($name)
    {
        $this->name = $name; 
    }

    public function getName()
    {
        return $this->name; 
    }
}
