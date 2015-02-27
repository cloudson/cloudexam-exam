<?php 

namespace CloudExam\Exam\Transfer;

class Question
{
    public $title; 
    public $slug;
    public $choices = array();

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setChoices(Array $choices)
    {
        $this->choices = $choices;
    }

    public function getChoices()
    {
        return $this->choices;
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
