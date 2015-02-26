<?php

namespace CloudExam\Exam\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="\CloudExam\Exam\Repository\Choice")
* @ORM\Table(name="Choice")   
* 
**/

class Choice 
{
    /**
     * @ORM\Id @ORM\Column @ORM\GeneratedValue
     */
    private $id;

    /**
    * @ORM\Column(type="integer")
    */ 
    private $questionId; 
    /**
     * @ORM\Column(type="string", length=225)
     */
    private $title; 
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt; 
    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;    

    public function getId()
    {
        return $this->id;
    }

    public function setQuestionId($questionId) 
    {
        $this->questionId = $questionId;
    }

    public function getQuestionId()
    {
        return $this->questionId;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
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
