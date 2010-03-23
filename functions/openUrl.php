<?php
/*
OpenURL() constructs an NISO Z39.88 compliant ContextObject for use in OpenURL links and COinS.  It returns 
the proper query string, which you must embed in a <span></span> thus:
 
<span class="Z3988" title="<?php print OpenURL($Document, $People) ?>">Content of your choice goes here</span>
 
This span will work with Zotero. You can also use the output of OpenURL() to link to your library's OpenURL resolver, thus:
 
<a href="http://www.lib.utexas.edu:9003/sfx_local?<?php print OpenURL($Document, $People); ?>" title="Search for a copy of this document in UT's libraries">Find it at UT!</a>
 
Replace "http://www.lib.utexas.edu:9003/sfx_local?" with the correct resolver for your library.
 
OpenURL() takes two arguments.
 
$Document - a document object, having an array (fields) with the following properties:
	$Document->fields["DocType"]
		1 = Article
		2 = Book Item (e.g. a chapter, section, etc)
		3 = Book
		4 = Unpublished MA thesis
		5 = Unpublished PhD thesis
 
	$Document->fields["DocTitle"] - Title of the document.
	$Document->fields["JournalTitle"] - Title of the journal/magazine the article was published in, or false if this is not an article.
 
	$Document->fields["BookTitle"] - Title of the book in which this item was published, or false if this is not a book item.
 
	$Document->fields["Volume"] - The volume of the journal this article was published in as an integer, or false if this is not an article.  Optional.
	$Document->fields["JournalIssue"] - The issue of the journal this article was published in as an integer, or false if this is not an article.  Optional.
	$Document->fields["JournalSeason"] Optional.
		The season of the journal this article was published in, as a string, where:
			Spring
			Summer
			Fall
			Winter
			false = not applicable
	$Document->fields["JournalQuarter"] - The quarter of the journal this article was published in as an integer between 1 and 4, or false. Optional.
	$Document->fields["ISSN"] - The volume of the journal this article was published in, or false.  Optional.
 
 
	$Document->fields["BookPublisher"] - The publisher of the book, or false. Optional.
	$Document->fields["PubPlace"] - The publication place, or false.  Optional.
	$Document->fields["ISBN"] - The ISBN of the book.  Optional but highly recommended.
 
	$Document->fields["StartPage"] - Start page for the article or item, or false if this is a complete book.
	$Document->fields["EndPage"] - End page for the article or item, or false if this is a complete book.
 
$Document->fields["DocYear"] - The year in which this document was published.
 
$People - An array of person objects, each having an array, fields, with these properties:
	$People->fields["DocRelationship"]
		An integer indicating what kind of relationship the person has to this document.
		0 = author
		1 = editor
		2 = translator
	$People->fields["FirstName"] - The person's first name.
	$People->fields["LastName"] - The person's last name.
*/
function OpenURL($Document, $People){
	$DocType = $Document->fields["DocType"];
	//if($DocType > 2){ return false; }
 
	// Base of the OpenURL specifying which version of the standard we're using.
	$URL = "ctx_ver=Z39.88-2004";
 
	// Metadata format - e.g. article or book.
	if($DocType == 0){ $URL .= "&amp;rft_val_fmt=info%3Aofi%2Ffmt%3Akev%3Amtx%3Ajournal"; }
	if($DocType > 0){ $URL .= "&amp;rft_val_fmt=info%3Aofi%2Ffmt%3Akev%3Amtx%3Abook"; }
 
	// An ID for your application.  Replace yoursite.com and specify a name for your application.
	$URL .= "&amp;rfr_id=info%3Asid%2F" . urlencode($_SERVER['HTTP_HOST'] . ': ' . trim(OBIB_LIBRARY_NAME));
 
	// Document Genre
	if($DocType == 0){ $URL .= "&amp;rft.genre=article"; }
	if($DocType == 1){ $URL .= "&amp;rft.genre=bookitem"; }
	if($DocType == 2){ $URL .= "&amp;rft.genre=book"; }
 
	// Document Title
	if($DocType < 2){ $URL .= "&amp;rft.atitle=".urlencode($Document->fields["DocTitle"]); }
	if($DocType == 2){ $URL .= "&amp;rft.btitle=".urlencode($Document->fields["DocTitle"]); }
 
	// Publication Title
	if($DocType == 0){ $URL .= "&amp;rft.jtitle=".urlencode($Document->fields["JournalTitle"]); }
	if($DocType == 1){ $URL .= "&amp;rft.btitle=".urlencode($Document->fields["BookTitle"]); }
 
	// Volume, Issue, Season, Quarter, and ISSN (for journals)
	if($DocType == 0){
		if($Document->fields["Volume"]){ $URL .= "&amp;rft.volume=".urlencode($Document->fields["Volume"]); }
		if($Document->fields["JournalIssue"]){ $URL .= "&amp;rft.issue=".urlencode($Document->fields["JournalIssue"]); }
		if($Document->fields["JournalSeason"]){ $URL .= "&amp;rft.ssn=".urlencode($Document->fields["JournalSeason"]); }
		if($Document->fields["JournalQuarter"]){ $URL .= "&amp;rft.quarter=".urlencode($Document->fields["JournalQuarter"]); }
		if($Document->fields["JournalQuarter"]){ $URL .= "&amp;rft.quarter=".urlencode($Document->fields["ISSN"]); }
	}
 
	// Publisher, Publication Place, and ISBN (for books)
	if($DocType > 0){
		$URL .= "&amp;rft.pub=".urlencode($Document->fields["BookPublisher"]);
		$URL .= "&amp;rft.place=".urlencode($Document->fields["PubPlace"]);
		$URL .= "&amp;rft.isbn=".urlencode($Document->fields["ISBN"]);
	}
 
	// Start page and end page (for journals and book articles)
	if($DocType < 2){
		$URL .= "&amp;rft.spage=".urlencode($Document->fields["StartPage"]);
		$URL .= "&amp;rft.epage=".urlencode($Document->fields["EndPage"]);
	}
 
	// Publication year.
	$URL .= "&amp;rft.date=".$Document->fields["DocYear"];
 
	// Authors
	$i = 0;
	while($People[$i]){
		if($People[$i]->fields["DocRelationship"] == 0){
			$URL .= "&amp;rft.au=".urlencode($People[$i]->fields["LastName"]).",+".urlencode($People[$i]->fields["FirstName"]);
		}
		$i++;
	}
 
	return $URL;
}

