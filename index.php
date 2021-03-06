<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Minimum Kindle Book Generator</title>
		<link href="./misc.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="./misc.js"></script>
	</head>
	<body>
		<div>
			<h1>Minimum Kindle Book Generator</h1>
		</div>

		<div>
			<h2>What's this?</h2>
			<p>You can make a kindle format book here.<br>Probably this service is suitable for a short document like a <a href="http://www.ted.com/">TED</a> movie's script, brief report and so on.</p>
		</div>

		<div>
			<h2>How to make?</h2>
			<p>1. Just input what you want to write below, like examples. <br>
				2. Click "generate book" button.<br>
				<br>Tips: "Tab" key is good for going to a next form.
			</p>
		</div>



		<div>
			<h2>Notes</h2>
			<p>1. This service generates a ridiculously simple and minimum Kindle book. No HTML tags, pics, URLs and so on.<br>
				2. You need to fill in at least three chapters.<br>
				3. If you want to make a rich Kindle book, try to find other better services.<br>
				4. Only English and Japanese available.<br>
				5. Please do not pirate. <br>
				6. To the extent you inputted original texts, the book you generated here belongs to you, you have a copyright of it and can use it as you want.<br>
			</p>
		</div>



		<div>
			<h2>Forms (Input here!)</h2>

			<form id="input_area" method="post" action="generate.php" onsubmit ="get_javascript_variable()">

				<!-- ---------- Example ---------- -->
				<div align ="center"><p><button type="button" value="Example" onclick="set_form();"><font size="+2">Set example</font></button><br>If you want to know how to input here, click this button.</p></div>

				<!-- ---------- Title ---------- -->
				<p><br>Title:<br><input type="text" name="title" size ="30"></p>

				<!-- ---------- Date ---------- -->
				<p><br>Date:<br><input type="text" name="date" size="30"></p>

				<!-- ---------- Creator ---------- -->
				<p><br>Creator:<br><input type="text" name="creator" size="30"></p>

				<!-- ---------- Publisher ---------- -->
				<!-- <p><br>Publisher:<br><input type="text" name="publisher" size="30"> (example: <input type="text" name="e_publisher" size="30" tabindex ="-1">)</p> -->

				<!-- ---------- Subject ---------- -->
				<p><br>Subject:<br><input type="text" name="subject" size="30"></p>

				<p><br>[Maximum number of characters in Description, Introduction and each Chapters is 65535]</p>

				<!-- ---------- Description ---------- -->
				<p><br>Description:<br><textarea name="description" rows="5" cols="100"></textarea></textarea><br></p>

				<!-- ---------- Inctroduction Title ---------- -->
				<p><br>Introduction Title: <br><input type="text" name="introduction_title" size="30"><br>Introduction: <br><textarea name="introduction_contents" rows="20" cols="150"></textarea><br></p>

				<!-- ---------- Contents ---------- -->
				<p><br>Chapter 1 Title: <br><input type="text" name="chapter001_title" size="30"><br>Chapter 1: <br><textarea name="chapter001_contents" rows="20" cols="150"></textarea><br></p>

				<p><br>Chapter 2 Title: <br><input type="text" name="chapter002_title" size="30"><br>Chapter 2: <br><textarea name="chapter002_contents" rows="20" cols="150"></textarea><br></p>

				<p><br>Chapter 3 Title: <br><input type="text" name="chapter003_title" size="30"><br>Chapter 3: <br><textarea name="chapter003_contents" rows="20" cols="150"></textarea><br></p>

				<!-- ---------- Additinal Chapters ---------- -->
				<div id="extra_chapters"></div>

				<!-- ---------- Add New Chapter ---------- -->
				<div align ="center"><p><button type="button" id="add_input_textarea" onclick="add();"><font size="+3">Add New Chapter</font></button><br>To add a chapter, click this button and a new chapter form will appear. Max 255 Chapters available.</p></div>

				<!-- ---------- Delete A Chapter ---------- -->
				<div align ="center"><p><br><br><button type="button" id="delete_input_textarea" onclick="delete_chapter();"><font size="+1">Delete Chapter</font></button><br>To delete a latest chapter, click this button and a latest chapter form will disappear.</p></div>

				<!-- ---------- generate book button ---------- -->
				<div align ="center"><p><br><br><button type="submit" id="generate_book" onclick=""><input type="hidden" name="hidden_input" value="" /><font size="+3">Generate Book</font></button><br>To generate a book after filling the forms above, click this button.<br>At least three chapters are needed.<input type="hidden" name="num" id="num" /></p></div>


			</form>
		</div>

		<!-- ---------- Contributer ---------- -->
		<!-- When pull request, please add your name and your contribution. -->
		<div>
			<h2>Contributer</h2>
			<p>- Name: KAWAMORITA Mitsuaki(kawa[♯ at.sign.com ♯]hongo.wide.ad.jp ( [♯ at.sign.com ♯] → @ )), firstly wrote this service.<br>
			</p>
		</div>

		<!-- ---------- ToDo ---------- -->
		<div>
			<h2>ToDo with who requested</h2>
			<p>- Make a Japanese UI Version [KAWAMORITA Mitsuaki]<br>
				- MarkDown or Textile style available [KAWAMORITA Mitsuaki]<br>
				- Send the book by email [KAWAMORITA Mitsuaki]<br>
				- Add other languages(now only English and Japanese) [KAWAMORITA Mitsuaki]<br>
			</p>
		</div>

		<!-- ---------- Copyright ---------- -->
		<div>
		</div>
    </body>
</html>
