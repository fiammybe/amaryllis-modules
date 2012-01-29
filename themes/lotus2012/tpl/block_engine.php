			<!--
				<{php }>
					$block_id = 3; 
					$theme = $GLOBALS['icmsConfig']['theme_set']; 
					include XOOPS_THEME_PATH.'/'.$theme.'/tpl/block_engine.php';
				<{/php}>
				<{$block.content}>			-->		

<?php
	$icmsobject = new icms_view_block_Object($block_id);
	$template = new icms_view_Tpl();
	$block = array(
		'id'        => $icmsobject->getVar( 'bid' ),
		'module'    => $icmsobject->getVar( 'dirname' ),
		'title'     => $icmsobject->getVar( 'title' ),
		'weight'    => $icmsobject->getVar( 'weight' ),
		'lastmod'   => $icmsobject->getVar( 'last_modified' ),
	);
	$tplName = ( $tplName = $icmsobject->getVar('template') ) ? "db:$tplName" : "db:system_block_dummy.html";	
	$bresult = $icmsobject->buildBlock() ; 
 		$template->assign( 'block', $bresult );
		$block['content'] = $template->fetch($tplName);
	
	 $this->assign('block', $block);	
?>