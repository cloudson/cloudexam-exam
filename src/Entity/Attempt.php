<?php

namespace CloudExam\Exam\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="\CloudExam\Exam\Repository\Attempt")
* @ORM\Table(name="Attempt")   
* 
**/
class Attempt
{

	/** 
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
	*/ 
	private $id;

	/**
	* @ORM\ManyToOne(targetEntity="Choice")
    * @ORM\JoinColumn(name="choice_id", referencedColumnName="id")
	*/ 
	private $choice;

	public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

	public function setChoice($choice)
	{
		$this->choice = $choice;
	}

	public function getChoice()
	{
		return $this->choice;
	}
}