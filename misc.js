var limit = 255;
var min_chapter_num = 3;
var counter = 4;
var text_size = 30;
var rows_num = 20;
var cols_num = 150;

function get_javascript_variable(){
	document.forms['input_area'].elements['hidden_input'].value = counter - 1;
}

function add()
{
	if(limit > counter )
	{
		var div_element = document.createElement("p");
				
		var str_counter = String(convert_num(counter, 3));
		
		div_element.id = "chapter" + str_counter;
		div_element.innerHTML = '<br>Chapter ' + String(counter) + ' Title: <br><input type="text" name="chapter' + str_counter + '_title"' + 'size="' + text_size + '"><br>' + 'Chapter ' + String(counter) +': <br><textarea name="chapter' + str_counter +'_contents" rows="' + rows_num + '" cols="' + cols_num + '"></textarea><br>';
		var parent_object = document.getElementById("extra_chapters");
		parent_object.appendChild(div_element);
					
		counter += 1;
					
	} 
	else
	{
		alert("Too many chapters! Can't make more than " + String(limit));
	}
}

function delete_chapter()
{
	if(window.confirm('Really OK to delete the latest chapter?')){
		if(counter > min_chapter_num + 1 )
		{
			var str_counter = String(convert_num(counter - 1, 3));
			var chapter = document.getElementById("chapter" + str_counter);
			chapter.parentNode.removeChild(chapter);
			
			counter -= 1;	
		} else
{
			alert("Can not delete the latest chapter! Chapters need to be more than " + String(min_chapter_num) + " chapters.");
		}
	}else{

		window.alert('Chancelled deleting.');

	}
}

function convert_num(num, figures) {
	var str = String(num);
	while (str.length < figures) {
		str = "0"+str;
	}
	return str;
}

window.onload = function() {
	
	/* generate default values */
	
	/* default date */
	dd = new Date();
	yy = dd.getYear();
	mm = dd.getMonth() + 1;
	dd = dd.getDate();
	if (yy < 2000) {
		yy += 1900;
	}
	if (mm < 10) {
		mm = "0" + mm;
	}
	if (dd < 10) {
		dd = "0" + dd;
	}
	document.forms['input_area'].elements['date'].value = yy + "-" + mm + "-" + dd;
	document.forms['input_area'].elements['e_date'].value = yy + "-" + mm + "-" + dd;
}

function set_form(){
	document.forms['input_area'].elements['title'].value = "The Great Gatsby";
	document.forms['input_area'].elements['date'].value = "1925-04-10";
	document.forms['input_area'].elements['creator'].value = "F. Scott Fitzgerald";
	//document.forms['input_area'].elements['publisher'].value = "";
	document.forms['input_area'].elements['subject'].value = "novel";
	document.forms['input_area'].elements['description'].value = 'The Great Gatsby is a novel by the American author F. Scott Fitzgerald. Written in 1925, it is often referred to as "The Great American Novel," and as the quintessential work which captures the mood of the "Jazz Age."';
	document.forms['input_area'].elements['introduction_title'].value = "Introduction";
	document.forms['input_area'].elements['introduction_contents'].value = "Then wear the gold hat, if that will move her;" + "\n" +'If you can bounce high, bounce for her too,' + "\n" +  'Till she cry “Lover, gold-hatted, high-bouncing lover,' + "\n" + 'I must have you!”' + "\n\n" + '―Thomas Parke D’Invilliers.';
	document.forms['input_area'].elements['chapter001_title'].value = "Chapter 1";
	document.forms['input_area'].elements['chapter001_contents'].value = 'In my younger and more vulnerable years my father gave me some advice that I’ve been turning over in my mind ever since.' + "\n\n" + '“Whenever you feel like criticizing any one,” he told me, “just remember that all the people in this world haven’t had the advantages that you’ve had.”' + "\n\n" + "He didn’t say any more, but we’ve always been unusually communicative in a reserved way, and I understood that he meant a great deal more than that. In consequence, I’m inclined to reserve all judgments, a habit that has opened up many curious natures to me and also made me the victim of not a few veteran bores. The abnormal mind is quick to detect and attach itself to this quality when it appears in a normal person, and so it came about that in college I was unjustly accused of being a politician, because I was privy to the secret griefs of wild, unknown men. Most of the confidences were unsought — frequently I have feigned sleep, preoccupation, or a hostile levity when I realized by some unmistakable sign that an intimate revelation was quivering on the horizon; for the intimate revelations of young men, or at least the terms in which they express them, are usually plagiaristic and marred by obvious suppressions. Reserving judgments is a matter of infinite hope. I am still a little afraid of missing something if I forget that, as my father snobbishly suggested, and I snobbishly repeat, a sense of the fundamental decencies is parcelled out unequally at birth.";
	document.forms['input_area'].elements['chapter002_title'].value = "Chapter 2";
	document.forms['input_area'].elements['chapter002_contents'].value = "About half way between West Egg and New York the motor road hastily joins the railroad and runs beside it for a quarter of a mile, so as to shrink away from a certain desolate area of land. This is a valley of ashes — a fantastic farm where ashes grow like wheat into ridges and hills and grotesque gardens; where ashes take the forms of houses and chimneys and rising smoke and, finally, with a transcendent effort, of men who move dimly and already crumbling through the powdery air. Occasionally a line of gray cars crawls along an invisible track, gives out a ghastly creak, and comes to rest, and immediately the ash-gray men swarm up with leaden spades and stir up an impenetrable cloud, which screens their obscure operations from your sight. But above the gray land and the spasms of bleak dust which drift endlessly over it, you perceive, after a moment, the eyes of Doctor T. J. Eckleburg. The eyes of Doctor T. J. Eckleburg are blue and gigantic — their irises are one yard high. They look out of no face, but, instead, from a pair of enormous yellow spectacles which pass over a nonexistent nose. Evidently some wild wag of an oculist set them there to fatten his practice in the borough of Queens, and then sank down himself into eternal blindness, or forgot them and moved away. But his eyes, dimmed a little by many paintless days, under sun and rain, brood on over the solemn dumping ground." + "\n\n" + "The valley of ashes is bounded on one side by a small foul river, and, when the drawbridge is up to let barges through, the passengers on waiting trains can stare at the dismal scene for as long as half an hour. There is always a halt there of at least a minute, and it was because of this that I first met Tom Buchanan’s mistress.";
	document.forms['input_area'].elements['chapter003_title'].value = "Chapter 3";
	document.forms['input_area'].elements['chapter003_contents'].value = "There was music from my neighbor’s house through the summer nights. In his blue gardens men and girls came and went like moths among the whisperings and the champagne and the stars. At high tide in the afternoon I watched his guests diving from the tower of his raft, or taking the sun on the hot sand of his beach while his two motor-boats slit the waters of the Sound, drawing aquaplanes over cataracts of foam. On week-ends his Rolls-Royce became an omnibus, bearing parties to and from the city between nine in the morning and long past midnight, while his station wagon scampered like a brisk yellow bug to meet all trains. And on Mondays eight servants, including an extra gardener, toiled all day with mops and scrubbing-brushes and hammers and garden-shears, repairing the ravages of the night before." +  "\n\n"+"Every Friday five crates of oranges and lemons arrived from a fruiterer in New York — every Monday these same oranges and lemons left his back door in a pyramid of pulpless halves. There was a machine in the kitchen which could extract the juice of two hundred oranges in half an hour if a little button was pressed two hundred times by a butler’s thumb.";
}

