<?php

/**
 * a class for generating Kindle mobi book
 *
 */
class KindleBook {

	private $title;
	private $date;
	private $creator;
	private $subject;
	private $description;
	private $introduction_title;
	private $introduction_contents;
	private $chapter_titles;
	private $chapter_contents;
	private $introduction;
	private $toc_ncx;
	private $table_of_contents;
	private $number_of_chapters;
	private $opf;
	private $chapter;
	private $directory_name;

	public function __construct($title, $date, $creator, $subject, $description, $introduction_title, $introduction_contents, $number_of_chapters, $chapter_titles, $chapter_contents) {
		$this->title = $title;
		$this->date = $date;
		$this->creator = $creator;
		$this->subject = $subject;
		$this->description = $description;
		$this->introduction_title = $introduction_title;
		$this->introduction_contents = $introduction_contents;
		$this->number_of_chapters = $number_of_chapters;
		$this->chapter_contents = $introduction_contents;
		$this->chapter_titles = $chapter_titles;
		$this->chapter_contents = $chapter_contents;
		$this->directory_name = md5(mt_rand() . ceil(microtime(true) * 1000) . uniqid(mt_rand()));
	}

	public function __toString() {
		$return =
				"title :" . $this->title . "<br><br>\n" .
				"date :" . $this->date . "<br><br>\n" .
				"creator : " . $this->creator . "<br><br>\n" .
				"subject : " . $this->subject . "<br><br>\n" .
				"description : " . $this->description . "<br><br>\n" .
				"intro_title : " . $this->introduction_title . "<br><br>\n" .
				"intro_contents : " . $this->introduction_contents . "<br><br>\n" .
				"number of chapters : " . $this->number_of_chapters . "<br><br>\n";
		for ($i = 1; $i <= $this->number_of_chapters; $i++) {
			$return .= "chapter" . sprintf("%03d", $i) . "_title : " . $this->chapter_titles[$i - 1] . "<br><br>\n";
			$return .= "chapter" . sprintf("%03d", $i) . "_contents : " . $this->chapter_contents[$i - 1] . "<br><br>\n";
		}
		return $return;
	}

	/*	 * ************************************** Introduction **************************************** */

	private function makeIntroduction() {

		$this->introduction = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>

<a name="introduction"/>

EOT;

		$this->introduction .= '<div align="left"><h2>' . $this->introduction_title . "</h2></div>\n";
		$this->introduction .= "<p>" . $this->introduction_contents . "</p>\n";

		$this->introduction .= <<<EOT
</body>
</html>
EOT;
	}

	/*	 * ************************************** Each Chapter **************************************** */

	private function makeSingleChapter($chapter_number, $isEndMark = false) {
		$chapter = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>

EOT;

		$chapter .= '<div align="left">' . "\n";
		$chapter .= '<h2><a name="C' . strval($chapter_number) . '">' . $this->chapter_titles[$chapter_number - 1] . '</a></h2>' . "</div>\n";
		$chapter .= '<div><p>' . $this->chapter_contents[$chapter_number - 1] . '</p>' . "\n";
		$chapter .= "</div>\n\n";

		if ($isEndMark == TRUE) {
			$chapter .= '<hr />' . "\n" . '<div align="center"><b>END</b></div>' . "\n" . "</body>\n</html>";
		} else {
			$chapter .= "</body>\n</html>";
		}

		return $chapter;
	}

	private function makeAllChapter() {
		$this->chapter = "";
		for ($i = 1; $i <= $this->number_of_chapters; $i++) {
			if ($i === $this->number_of_chapters) {
				$this->chapter .= self::makeSingleChapter($i, TRUE); // with END mark at the last chapter
			} else {
				$this->chapter .= self::makeSingleChapter($i);
			}
		}
	}

	/*	 * ************************************** TOC / NCX **************************************** */

	private function makeTOC_NCX() {

		$this->toc_ncx = <<<EOT
<?xml version="1.0"?>

<!DOCTYPE ncx PUBLIC "-//NISO//DTD ncx 2005-1//EN" "http://www.daisy.org/z3986/2005/ncx-2005-1.dtd">

<ncx xmlns="http://www.daisy.org/z3986/2005/ncx/" version="2005-1">

<head>
</head>

<docTitle>
<text>KF8</text>
</docTitle>

<navMap>

EOT;

		//add Table of Contents
		$this->toc_ncx .= self::makeNavi(1, "Table Of Contents", "table_of_contents.html#TOC");
		$this->toc_ncx .= "\n\n";

		//add Introduction
		$this->toc_ncx .= self::makeNavi(2, $this->introduction_title, "introduction.html#introduction");
		$this->toc_ncx .= "\n\n";

		//add Chapters
		$cnt = 1;
		while (TRUE) {
			if ($cnt === ($this->number_of_chapters + 1)) {
				break;
			}

			$temp_html = 'chapter' . sprintf("%03d", $cnt) . '.html#C' . strval($cnt);
			$this->toc_ncx .= self::makeNavi($cnt + 2, $this->chapter_titles[$cnt - 1], $temp_html);
			$this->toc_ncx .= "\n\n";

			$cnt += 1;
		}

		$this->toc_ncx .= "\n\n</navMap>\n</ncx>";
	}

	/*	 * ************************************** TOC **************************************** */

	private function makeTOC() {

		$this->table_of_contents = <<< EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>

<body>

<div align="left"><h2><a name="TOC">Table Of Contents</a></h2></div>
<div>

EOT;

		$this->table_of_contents .= "\n";
		$this->table_of_contents .= '<h4><a href="./introduction.html">' . $this->introduction_title . ' </a></h4>' . "\n";

		$cnt = 1;
		while (TRUE) {
			if ($cnt === ($this->number_of_chapters + 1)) {
				break;
			}

			$this->table_of_contents .= '<h4><a href="./chapter' . sprintf("%03d", $cnt) . '.html#C' . strval($cnt) . '">' . $this->chapter_titles[$cnt - 1] . '</a></h4>' . "\n";
			$cnt += 1;
		}

		$this->table_of_contents .= "</div></body></html>";
	}

	/*	 * ************************************** OPF **************************************** */

	private function makeOPF() {

		$this->opf = <<<EOT
<?xml version="1.0" encoding="utf-8"?>
<package unique-identifier="uid">
<metadata>
<dc-metadata xmlns:dc="http://purl.org/metadata/dublin_core"
xmlns:oebpackage="http://openebook.org/namespaces/oeb-package/1.0/">

<dc:Title>$this->title</dc:Title>
<dc:Language>en</dc:Language>
<dc:Creator>$this->creator</dc:Creator>
<dc:Description>$this->description</dc:Description>
<dc:Date>$this->date</dc:Date>
</dc-metadata>
<x-metadata>
<output encoding="utf-8" content-type="text/x-oeb1-document">
</output>
<EmbeddedCover>./cover.gif</EmbeddedCover>
</x-metadata>
</metadata>
<manifest>
<item id="cover-image" media-type="image/gif" href="./cover.gif" />
<item id="introduction" media-type="text/x-oeb1-document" href="./introduction.html"></item>	
<item id="table_of_contents" media-type="text/x-oeb1-document" href="./table_of_contents.html"></item>
<item id="My_Table_of_Contents" media-type="application/x-dtbncx+xml" href="./toc.ncx"></item>

EOT;

		for ($index = 1; $index <= $this->number_of_chapters; $index++) {
			$this->opf .= '<item id="chapter' . strval($index) . '" media-type="text/x-oeb1-document" href="./chapter' . sprintf("%03d", $index) . '.html"></item>' . "\n";
		}

		$this->opf .= <<<EOT
</manifest>
<spine toc="My_Table_of_Contents">
<itemref idref="cover-image" />
<itemref idref="introduction" />
<itemref idref="table_of_contents" />
<itemref idref="My_Table_of_Contents" />

EOT;
		for ($index = 1; $index <= $this->number_of_chapters; $index++) {
			$this->opf .= '<itemref idref="chapter' . strval($index) . '" />' . "\n";
		}

		$this->opf .= <<<EOT
</spine>
<tours></tours>
<guide>
<reference type="text" title="Startup Page" href="./chapter001.html#C1"></reference>
<reference type="toc" title="Table of Contents" href="./table_of_contents.html#TOC"></reference>
</guide>
</package>
EOT;
	}

	function write_all_files() {

		// mkdir
		if (!file_exists("./books/")) {
			mkdir("./books/");
		}
		mkdir("./books/" . $this->directory_name);

		// your_ebook.opf
		self::makeOPF();
		self::write_file("your_ebook.opf", $this->opf);

		// introduction.html
		self::makeIntroduction();
		self::write_file("introduction.html", $this->introduction);

		// table_of_contents.html
		self::makeTOC();
		self::write_file("table_of_contents.html", $this->table_of_contents);

		// toc.ncx
		self::makeTOC_NCX();
		self::write_file("toc.ncx", $this->toc_ncx);

		// chapter001.html, chapter002.html, chapter003.html, ...
		for ($i = 1; $i <= $this->number_of_chapters; $i++) {
			if ($i === $this->number_of_chapters) {
				// with END mark at the last chapter
				self::write_file("chapter" . sprintf("%03d", $i) . ".html", self::makeSingleChapter($i, TRUE));
			} else {
				self::write_file("chapter" . sprintf("%03d", $i) . ".html", self::makeSingleChapter($i));
			}
		}

		// make a cover
		self::makeCover();
	}

	/**
	 * please use this method after write_all_files
	 */
	function generateKindle() {
		// exec kindlegen
		$output = "";
		$date = date("Y-m-d");
		exec('./kindlegen -locale en ' . "./books/" . $this->directory_name . "/" . $date . "_your_ebook.opf", $output);

		// downloadlink
		if (file_exists("./books/" . $this->directory_name . '/your_ebook.mobi')) {
			$link = "./books/" . $this->directory_name . '/your_ebook.mobi';
		} else {
			die("Looks like failed to generate the book.");
		}

		return array($link, $output);
	}

	static function printKindleGenLog($output) {
		//kindlegen log
		print "<div>\n";
		print "<p><br>----- kindlegen log -----<br>";
		foreach ($output as $elm) {
			print $elm . "<br>";
		}
		print "<br>----- kindlegen log-----</p>\n";
		print '<p>PS: Message(above) of ( <font color="red">' . "Info(pagemap):I8000: No Page map found in the book" . "</font> ) is not so important that you don't need to care.<br>You can read the generated ebook properly.<br>In my investigation, this slight warning is about which a NCX file exits or not.</p>\n";

		print "</div>\n";
	}

	private function makeNavi($num, $title, $content_html) {
		return '<navPoint id="navpoint-' . strval($num) . '" playOrder="' . strval($num) . '"><navLabel><text>' . $title . '</text></navLabel><content src="' . $content_html . '"/></navPoint>';
	}

	private function write_file($file_name, $contents) {
		$path = "./books/" . $this->directory_name . "/" . $file_name;
		if (touch($path)) {
			chmod($path, 0777);
			//printf("\n '%s' making a file successed .\n", $file_name);
		} else {
			echo 'Sorry, could not change modification time of ' . $path;
			exit("error! terminated.");
		}

		$fh = fopen($path, "w");
		if ($fh) {
			if (flock($fh, LOCK_EX)) {
				fwrite($fh, $contents);
				flock($fh, LOCK_UN);
			} else {
				echo "f-lock error!!";
			}
			fclose($fh);
		} else {
			echo "open error!!";
		}
	}

	/* ---------- make a cover gif ---------- */

	private function makeCover() {
		try {
			$cover_image_width = 600;
			$cover_image_height = 800;
			$font_size_title = 36;
			$font_size_creater = 18;
			$font_file = "./ipagui-mona.ttf";
			$img = ImageCreate($cover_image_width, $cover_image_height);
			$text_title = mb_convert_encoding($this->title, 'UTF-8', 'auto');
			$text_creater = mb_convert_encoding($this->creator, 'UTF-8', 'auto');
			$title_up = 45;
			$creater_down = $title_up + 15;

			//color of whitesmoke
			$whitesmoke = ImageColorAllocate($img, 0xf5, 0xf5, 0xf5);
			ImageFilledRectangle($img, 0, 0, $cover_image_width, $cover_image_height, $whitesmoke);

			//mesure the size of texts
			list($title_text_box_width, $title_text_box_height) = self::measure_text_box_size($font_size_title, $this->title, $font_file);
			$title_start_x = (int) (($cover_image_width / 2) - ($title_text_box_width / 2));
			$title_start_y = (int) (($cover_image_height / 2) - ($title_text_box_height / 2)) - $title_up;

			//writing the title on the proper area
			$black = ImageColorAllocate($img, 0x00, 0x00, 0x00);
			ImageTTFText($img, $font_size_title, 0, $title_start_x, $title_start_y, $black, $font_file, $text_title);

			//mesure the size of creator
			list($creater_text_box_width, $creater_text_box_height) = self::measure_text_box_size($font_size_creater, $this->creator, $font_file);
			$creater_start_x = (int) (($cover_image_width / 2) - ($creater_text_box_width / 2));
			$creater_start_y = (int) (($cover_image_height / 2) - ($creater_text_box_height / 2)) + $creater_down;

			//writing the creator name on th proper area
			ImageTTFText($img, $font_size_creater, 0, $creater_start_x, $creater_start_y, $black, $font_file, $text_creater);

			//output
			imagegif($img, "./books/" . $this->directory_name . "/cover.gif");

			imagedestroy($img);
		} catch (Exception $e) {
			print "Error!\n";
			echo "Exception: ", $e->getMessage(), "\n";
		}
	}

	private function measure_text_box_size($font_size, $text, $font_file) {
		$text = mb_convert_encoding($text, 'UTF-8', 'auto');
		$text_box = imagettfbbox($font_size, 0, $font_file, $text);

		$width = $text_box[2] - $text_box[0];
		$height = $text_box[1] - $text_box[5];

		return array($width, $height);
	}

}

?>
