<?php

/**
 * a class for generating Kindle mobi book
 *
 */
class KindleFile {

	var $title;
	var $date;
	var $creator;
	var $subject;
	var $description;
	var $introduction_title;
	var $introduction_contents;
	var $chapter_titles;
	var $chapter_contents;
	var $introduction;
	var $toc_ncx;
	var $table_of_contents;
	var $number_of_chapters;
	var $opf;
	
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

	function makeIntroduction() {

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

	function makeChapter($cha_number, $cha_title, $cha_content, $isEndMark = false) {

		$chapter = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>

EOT;

		$chapter .= '<div align="left">' . "\n";
		$chapter .= '<h2><a name="C' . strval($cha_number) . '">' . $cha_title . '</a></h2>' . "</div>\n";
		$chapter .= '<div><p>' . $cha_content . '</p>' . "\n";
		$chapter .= "</div>\n\n";

		if ($isEndMark == TRUE) {
			$chapter .= '<hr />' . "\n" . '<div align="center"><b>END</b></div>' . "\n" . "</body>\n</html>";
		} else {
			$chapter .= "</body>\n</html>";
		}

		return $chapter;
	}

	/*	 * ************************************** TOC / NCX **************************************** */

	function makeTOC_NCX() {

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
		$this->toc_ncx .= makeNavi(1, "Table Of Contents", "table_of_contents.html#TOC");
		$this->toc_ncx .= "\n\n";

		//add Introduction
		$this->toc_ncx .= makeNavi(2, $this->introduction_title, "introduction.html#introduction");
		$this->toc_ncx .= "\n\n";

		//add Chapters
		$nav_num = 3;
		$cnt = 1;
		while (TRUE) {
			if ($cnt === ($this->number_of_chapters + 1)) {
				break;
			}

			$temp_html = 'chapter' . sprintf("%03d", $cnt) . '.html#C' . strval($cnt);
			$this->toc_ncx .= makeNavi($nav_num, $this->chapter_titles[$cnt - 1], $temp_html);
			$this->toc_ncx .= "\n\n";

			$cnt += 1;
		}

		$this->toc_ncx .= "\n\n</navMap>\n</ncx>";
	}

	/*	 * ************************************** TOC **************************************** */

	function makeTOC() {

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

	function makeOPF() {

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

}

function makeNavi($num, $title, $content_html) {
	return '<navPoint id="navpoint-' . strval($num) . '" playOrder="' . strval($num) . '"><navLabel><text>' . $title . '</text></navLabel><content src="' . $content_html . '"/></navPoint>';
}

?>
