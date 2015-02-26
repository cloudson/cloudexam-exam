<?php 

namespace CloudExam\Exam\Transfer;

class Exam 
{
    public $name; 
    public $slug;
    public $questionsURI;
    protected $id;

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

    public function setQuestionsURI($questionsURI)
    {
        $this->questionsURI = $questionsURI;
    }

    public function getQuestionsURI()
    {
        return $this->questionsURI;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }



}
