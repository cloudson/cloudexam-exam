<?php

namespace CloudExam\Exam\Transfer;

class Attempt
{
	private $choiceTitle;
	private $questionSlug;

	public function setChoiceTitle($title)
	{
		$this->choiceTitle = $title;
	}

	public function getChoiceTitle()
	{
		return $this->choiceTitle;
	}

	public function setQuestionSlug($slug)
	{
		$this->questionSlug = $slug;
	}

	public function getQuestionSlug()
	{
		return $this->questionSlug;
	}
}