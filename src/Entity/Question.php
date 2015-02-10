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
     * @ORM\GeneratedValue
     * @ORM\Column 
     */
    protected $id;
            protected $name;

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
}

