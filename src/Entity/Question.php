<?php

namespace CloudExam\Exam\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="\CloudExam\Exam\Repository\Question")
* @ORM\Table(name="Question")   
* 
**/
class Question
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;


    /**
     * @ORM\Column(type="string", length=225)
     */
    protected $title;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;


    protected $exam;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
         return $this->title;
    }

    public function setExam($exam)
    {
        $this->exam = $exam; 
    }

    public function getExam()
    {
        return $this->exam;
    }

    public function setCreatedAt($created)
    {
        $this->createdAt = $created;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }   

    public function setUpdateAt($created)
    {
        $this->updatedAt = $created;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

}

