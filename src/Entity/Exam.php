<?php

namespace CloudExam\Exam\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\CloudExam\Exam\Repository\Exam")
 * @ORM\Table(name="Exam")
 * 
 */ 
class Exam
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
    protected $id;

     /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /** 
    * @ORM\Column(type="string", length=255)
    */ 
    protected $name; 

    /** 
    * @ORM\Column(type="string", length=255)
    */ 
    protected $slug; 

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function  setName($name)
    {
        $this->name = $name; 
    }

    public function getName()
    {
        return $this->name; 
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

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
         return $this->slug;
    }
}
