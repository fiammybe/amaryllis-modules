		
<?php
$block_handler = xoops_gethandler('block');
$xobject = $block_handler->get($block_id, true);

$template = new icms_view_Tpl();
$block = array(
'id'        => $xobject->getVar( 'bid' ),
'module'    => $xobject->getVar( 'dirname' ),
'title'     => $xobject->getVar( 'title' ),
'weight'    => $xobject->getVar( 'weight' ),
'lastmod'   => $xobject->getVar( 'last_modified' ),
);
$tplName = ( $tplName = $xobject->getVar('template') ) ? "db:$tplName" : "db:system_block_dummy.html";
if ( $bresult = $xobject->buildBlock() ) {
	$template->assign( 'block', $bresult );
	$block['content'] = $template->fetch($tplName);
} else {
	$block = false;
}
$this->assign('block', $block);
?>