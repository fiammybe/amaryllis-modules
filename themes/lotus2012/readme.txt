Theme: Lotus 2012
Please keep this readme.txt and the rights-folder untouched, thanks.

Block overview:
[  1     ][7]
[  2  ][5][8]
[  3  ][6][9]
[  4  ]

1. = Eyecatcher for the Gallery block (article-Module) => Center Block - left == CSS: class="eyecatcher"
2. = Main Content == CSS: id="content"
3. = Center Block => Center Block - Center == CSS: class="topcenter"
4. = BottomBlock - Center == CSS: class="bottomblock-center"
5. = SideBlock - Left == CSS: class="leftblocks"
6. = BottomBlock - Left == CSS: class="bottomblock-left"
7. = SideBlock - Right == CSS: class="rightblocks"
8. = CenterBlock Right == CSS: class="topright"
9. = BottomBlock Right == CSS: class="bottomblock-right"

The hack-folder:
The TinyMCE standard-template is to big for the frontend. Take a closer look to the hack-folder to fix this problem.

Block_engine.php:
With this code you can shift HTML-code like the navigation to the Blockmanager ->

<!-- Block -->
<{php }>
	$block_id = 1; 
	$theme = $GLOBALS['icmsConfig']['theme_set']; 
	include ICMS_THEME_PATH.'/'.$theme.'/tpl/block_engine.php';
<{/php}>
<{$block.content}> 

Step-by-Step Manual:
The "Example-Goal" is to include the navigation into a Block from the Blockmanager.
This solution offers you editing your navigation online. So you do not need FTP. 
-First of all, you'll need a Custom-Block. You can clone one of the Custom-Blocks to get one. 
There for: go to your administration, click "Blocks" in the Controll-Panel.
-Filter your list with: "module" and "none". Now you should see one or two "Custom Block (Auto Format + smilies)".
-Clone one of them by clicking the Clone-Icon on the right side.
-Give an informative Title like "my Navigation".
-For the content, we need the HTML-Code we like to include. 
For our example, go to the folder *icms-rootpath*/themes/lotus2012/tpl/ and open the navigation.html with an texteditor.
Copy the full text and include the text into the Block-Content. Your Content should now look like:

   										<a href="<{$icms_url}>/#" title="Link To The World-News Page">WORLD NEWS</a>                                    
                                        <a href="#" title="Link To The Sport Page">SPORTS</a>
                                        <a href="#" title="Link To The Business-News Page">BUSINESS</a>
                                        <a href="<{$icms_url}>/#" title="Link To The Movies-News Page">MOVIES</a>
                                        <a href="<{$icms_url}>/#" title="Link To The Entertainment-News Page">ENTERTAINMENT</a>
                                        <a href="<{$icms_url}>/#" title="Link To The Culture-News Page">CULTURE</a>
                                        <a href="<{$icms_url}>/#" title="Link To The Tech-News Page">TECH</a>
                                        <a href="<{$icms_url}>/#" title="Link To The Financial-News Page">FINANCIAL</a>

- Set the "Visible *"-option to NO
- Set the "Content Type*"-option to "Auto Format (smilies disabled)"
- Take a look to the URL in your browser-bar. At the end you find a number. This number is your block_ID. Remeber this number.
- Save the Block.
- Go back to the "navigation.html"
- replace the old code with the following code:

	<!-- Block -->
	<{php }>
		$block_id = 1; 
		$theme = $GLOBALS['icmsConfig']['theme_set']; 
		include ICMS_THEME_PATH.'/'.$theme.'/tpl/block_engine.php';
	<{/php}>
	<{$block.content}> 
	
- Now it is very important, that you edit the third line of this code -> $block_id = 1; Replace the "1" with your own block_id.
- Save the file.

Okay, that's it! Now you should be able to edit your Navigation online.	


Visit https://www.assembla.com/code/lotus23/subversion/node/logs/themes/trunk/lotus2012?rev=23 for bugfixes.

Article-Modul:
The theme is optimated for the Article Modul by QM-B. You can find special Blocks in the folder "/themes/lotus2012/modules/article/blocks/"
The Gallery-Block includes a javascript based Slideshow, showing your last news.

Other Templates:
Also I add better templates for the search-result and the comment-section. 
This templates are made by René Sato, one of the german ICMS-Members.

Please keep this readme.txt and the rights-folder untouched, thanks.