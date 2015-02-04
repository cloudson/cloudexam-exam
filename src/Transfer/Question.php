<?php 

namespace CloudExam\Exam\Transfer;

class Question
{
    protected $id; 
    protected $name; 
    protected $choices = array();

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setChoices(Array $choices)
    {
        $this->choices = $choices;
    }

    public function getChoices()
    {
        return $this->choices;
    }
}
