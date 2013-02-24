<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<?php
require "./Lib/Field.php";
require "./Lib/KindleFile.php";


error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('America/Los_Angeles');

$parameter_array = array("title", "date", "creator", "subject", "description", "introduction_title", "introduction_contents", "chapter001_title", "chapter001_contents", "chapter002_title", "chapter002_contents", "chapter003_title", "chapter003_contents");

// if parameter data is empty, put error message.
foreach ($parameter_array as $parameter_name) {
	if (empty($_POST[$parameter_name])) {
		ErrorMessage::empty_parameter($parameter_name);
	}
}

$title = new Title($_POST["title"]);
$date = new Date($_POST["date"]);
$creator = new Creator($_POST["creator"]);
$subject = new Subject($_POST["subject"]);
$description = new Description($_POST["description"]);
$intro_title = new IntroductionTitle($_POST["introduction_title"]);
$intro_contents = new Introduction($_POST["introduction_contents"]);
$ch001_title = new ChapterTitle($_POST["chapter001_title"]);
$ch001_contents = new Chapter($_POST["chapter001_contents"]);
$ch002_title = new ChapterTitle($_POST["chapter002_title"]);
$ch002_contents = new Chapter($_POST["chapter002_contents"]);
$ch003_title = new ChapterTitle($_POST["chapter003_title"]);
$ch003_contents = new Chapter($_POST["chapter003_contents"]);

// validation
if (!$date->validate()) {
	$date->error_invalid_parameter();
}

// get number of chapters
try {
	$number_of_chapters = intval(isset($_POST['hidden_input']) ? $_POST['hidden_input'] : 0);
} catch (ErrorException $e) {
	die("[Internal Server ERROR] So sorry for your convenience, coould not generate the book. Seems like this system has partialy broken. I'm going to fix it. [" . $e->getMessage() . "]<br>\n");
}

// get another chapter's titles and contents and gather up together.
$chapter_titles = array($ch001_title, $ch002_title, $ch003_title);
$chapter_contents = array($ch001_contents, $ch002_contents, $ch003_contents);
for ($i = 4; $i <= $number_of_chapters; $i++) {
	$temp_chapter_number = sprintf("%03d", $i);
	$temp_chapter_title = "chapter" . $temp_chapter_number . "_title";
	$temp_chapter_contents = "chapter" . $temp_chapter_number . "_contents";

	// if empty
	if (empty($_POST[$temp_chapter_title])) {
		ErrorMessage::empty_parameter($temp_chapter_title);
	}
	if (empty($_POST[$temp_chapter_contents])) {
		ErrorMessage::empty_parameter($temp_chapter_contents);
	}

	$chapter_titles[] = new ChapterTitle($_POST[$temp_chapter_title]);
	$chapter_contents[] = new Chapter($_POST[$temp_chapter_contents]);
}

$mobibook = new KindleFile($title, $date, $creator, $subject, $description, $intro_title, $intro_contents, $number_of_chapters, $chapter_titles, $chapter_contents);

echo (string)$mobibook;


?>