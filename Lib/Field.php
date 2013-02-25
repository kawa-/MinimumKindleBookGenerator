<?php

/**
 * Class Set of Title, Date, and so on.
 *
 * @author KAWAMORITA Mitsuaki
 */

abstract class Field {

	const MAX_LEN_DATE = 12; // like 2013-02-24
	const MAX_LEN_TITLE = 255;
	const MAX_LEN_CREATOR = 255;
	const MAX_LEN_SUBJECT = 255;
	const MAX_LEN_DESC = 65535;
	const MAX_LEN_INTRO_TITLE = 255;
	const MAX_LEN_INTRO_CONTENTS = 65535;
	const MAX_LEN_CHAPTER_TITLE = 255;
	const MAX_LEN_CHAPTER_CONTENTS = 65535;

	abstract function validate();

	abstract function __construct($str);

	abstract function __toString();

	protected function cutString($str, $length) {
		return nl2br(mb_strcut($str, 0, $length, 'UTF-8'));
	}

}

class Title extends Field {

	var $title;

	public function __construct($title) {
		$this->title = parent::cutString($title, parent::MAX_LEN_TITLE);
	}

	public function __toString() {
		return $this->title;
	}

	public function validate() {
		;
	}

}

class Date extends Field {

	var $date;

	public function __construct($date) {
		$this->date = parent::cutString($date, parent::MAX_LEN_DATE);
	}

	public function __toString() {
		return $this->date;
	}

	public function validate() {
		$pattern = '/^[0-9]{4}\-[0-1]{1}[0-9]{1}\-[0-3]{1}[0-9]{1}$/'; // naive. fix it someday.
		if (!preg_match($pattern, $this->date)) {
			return false;
		}
		return true;
	}
	
	public function error_invalid_parameter()
	{
		die("[ERROR] Invalid date form. Please write like 2013-02-18.<br>\n");
	}

}

class Creator extends Field {

	var $creator;

	public function __construct($creator) {
		$this->creator = parent::cutString($creator, parent::MAX_LEN_CREATOR);
	}

	public function __toString() {
		return $this->creator;
	}

	public function validate() {
		
	}

}

class Subject extends Field {

	var $subject;

	public function __construct($subject) {
		$this->subject = parent::cutString($subject, parent::MAX_LEN_SUBJECT);
	}

	public function __toString() {
		return $this->subject;
	}

	public function validate() {
		
	}

}

class Description extends Field {

	var $desc;

	public function __construct($description) {
		$this->desc = parent::cutString($description, parent::MAX_LEN_DESC);
	}

	public function __toString() {
		return $this->desc;
	}

	public function validate() {
		
	}

}

class IntroductionTitle extends Field {

	var $intro_title;

	public function __construct($intro_title) {
		$this->intro_title = parent::cutString($intro_title, parent::MAX_LEN_INTRO_TITLE);
	}

	public function __toString() {
		return $this->intro_title;
	}

	public function validate() {
		
	}

}

class Introduction extends Field {

	var $intro;

	public function __construct($intro) {
		$this->intro = parent::cutString($intro, parent::MAX_LEN_INTRO_CONTENTS);
	}

	public function __toString() {
		return $this->intro;
	}

	public function validate() {
		
	}

}

class ChapterTitle extends Field {

	var $chapter_title;

	public function __construct($title) {
		$this->chapter_title = parent::cutString($title, parent::MAX_LEN_CHAPTER_TITLE);
	}

	public function __toString() {
		return $this->chapter_title;
	}

	public function validate() {
		
	}

}

class Chapter extends Field {

	var $chapter;

	public function __construct($chapter) {
		$this->chapter = parent::cutString($chapter, parent::MAX_LEN_CHAPTER_CONTENTS);
	}

	public function __toString() {
		return $this->chapter;
	}

	public function validate() {
		
	}

}

class ErrorMessage {

	static function empty_parameter($parameter) {
		printf("[ERROR] '%s' is empty. Please input.<br>\n", $parameter);
		die();
	}
}

class Debug {

	static function print_key($key) {
		var_dump($key);
	}

	static function print_key_value($key, $value) {
		printf("%s | %s<br>\n", $key, $value);
	}

}

?>
