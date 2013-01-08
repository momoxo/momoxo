<?php

require_once dirname(__FILE__).'/PagesControllerAbstract.class.php' ;
require_once dirname(__FILE__).'/PagesModelCategory.class.php' ;
require_once dirname(__FILE__).'/PagesModelContent.class.php' ;
require_once dirname(__FILE__).'/gtickets.php' ;
require_once dirname(dirname(__FILE__)).'/include/history_functions.php' ;

class PagesControllerEditContent extends PagesControllerAbstract {

//var $mydirname = '' ;
//var $mytrustdirname = '' ;
//var $assign = array() ;
//var $mod_config = array() ;
//var $uid = 0 ;
//var $currentCategoryObj = null ;
//var $permissions = array() ;
//var $is_need_header_footer = true ;
//var $template_name = '' ;
//var $html_header = '' ;
//var $contentObjs = array() ;

function execute( $request )
{
    // check existence
    if( pages::isMember() == false ) {
        redirect_header( XOOPS_URL."/modules/$this->mydirname/index.php" , 2 , _MD_PAGES_ERR_READCONTENT ) ;
        exit ;
    }
	parent::execute( $request ) ;

	// makecontent/contentmanager
	$page = empty( $request['makecontent'] ) ? 'contentmanager' : 'makecontent' ;

	// $contentObj
	$contentObj = new PagesContent( $this->mydirname , $request['content_id'] , $this->currentCategoryObj , $page == 'makecontent' ) ;

	// check existence
	if( $contentObj->isError() ) {
		redirect_header( XOOPS_URL."/modules/$this->mydirname/index.php" , 2 , _MD_PAGES_ERR_READCONTENT ) ;
		exit ;
	}

	// fetch data from DB
	$cat_data = $this->currentCategoryObj->getData() ;
	$this->assign['category'] = $this->currentCategoryObj->getData4html() ;
	$content_data = $contentObj->getData() ;
	$this->assign['content_base'] = $contentObj->getData4html( true ) ;
	$this->contentObjs['content_base'] =& $contentObj ;
	$this->assign['content'] = $contentObj->getData4edit() ;
	
	// contentデータの値を渡す
	$this->assign['content_approval'] = $content_data['approval'];
    $this->assign['content_visible'] = $content_data['visible'];
    $this->assign['content_id'] =  $content_data['content_id'] ;

	// permission check
	if( $page == 'makecontent' ) {
		if( empty( $cat_data['can_post'] ) ) {
			redirect_header( XOOPS_URL.'/' , 2 , _MD_PAGES_ERR_CREATECONTENT ) ;
		}
	} else {
        if(pages::isMember()==false){
			// #7983 新規作成時申請待ちの間、editはできないが表示できるようにする<取り消し
			//if($content_data['visible'] == true){
            //	redirect_header( XOOPS_URL.'/' , 2 , $content_data['locked'] ? _MD_PAGES_ERR_LOCKEDCONTENT : _MD_PAGES_ERR_EDITCONTENT ) ;
            //}
		}
	}

	// category list can be read for category jumpbox etc.
	$categoryHandler = new PagesCategoryHandler( $this->mydirname , $this->permissions ) ;
	$categories = $categoryHandler->getAllCategories() ;
	$this->assign['categories_can_post'] = array() ;
	foreach( $categories as $tmpObj ) {
		$tmp_data = $tmpObj->getData() ;
		if( empty( $tmp_data['can_post'] ) && empty( $tmp_data['can_edit'] ) ) continue ;
		$this->assign['categories_can_post'][ $tmp_data['id'] ] = str_repeat('--',$tmp_data['cat_depth_in_tree']).$tmp_data['cat_title'] ;
	}

	// vpath options
	$this->assign['content']['wraps_files'] = array( '' => '---' ) + pages_main_get_wraps_files_recursively( $this->mydirname , '/' ) ;

	// breadcrumbs
	$breadcrumbsObj =& AltsysBreadcrumbs::getInstance() ;
	if( $page == 'makecontent' ) {
		$breadcrumbsObj->appendPath( '' , _MD_PAGES_LINK_MAKECONTENT ) ;
		$this->assign['xoops_pagetitle'] = _MD_PAGES_LINK_MAKECONTENT ;
	} else {
		$breadcrumbsObj->appendPath( XOOPS_URL.'/modules/'.$this->mydirname.'/'.$this->assign['content']['link'] , $this->assign['content']['subject'] ) ;
		$breadcrumbsObj->appendPath( '' , _MD_PAGES_CONTENTMANAGER ) ;
		$this->assign['xoops_pagetitle'] = _MD_PAGES_CONTENTMANAGER ;
	}
	$this->assign['xoops_breadcrumbs'] = $breadcrumbsObj->getXoopsbreadcrumbs() ;

	// misc assigns
	$this->assign['content_histories'] = pages_get_content_histories4assign( $this->mydirname , $content_data['id'] ) ;
	$this->assign['page'] = $page ;
	$this->assign['formtitle'] = $page == 'makecontent' ? _MD_PAGES_LINK_MAKECONTENT : _MD_PAGES_LINK_EDITCONTENT ;
	$this->assign['gticket_hidden'] = $GLOBALS['xoopsGTicket']->getTicketHtml( __LINE__ , 1800 , 'pages') ;

	// newsの時、アイコン一覧を渡す
	if(pages::getModuleDirName() == 'news'){
		$altFileArray = pages::getFileNameAltFromDir(XOOPS_ROOT_PATH.'/modules/news/images/icon');
		$this->assign['icon'] = $altFileArray['icon'];
		$this->assign['alt'] = $altFileArray['alt'];
	}

    // 編集者グループか？
    $contentsAdmin = pages::isContentsAdministrator();
	$this->assign['contentsAdmin'] = $contentsAdmin ;


	// views
	$this->template_name = $this->mydirname.'_main_content_form.html' ;
	$this->is_need_header_footer = true ;

	// preview
	$this->processPreview( $request ) ;

	// editor (wysiwyg etc)
	if(($content_data['visible'] == 1) and ($content_data['approval'] == 0)){
		// 承認されたものを修正して申請中の時
		//$editor_assigns = $this->getEditorAssigns( 'body' , htmlspecialchars_decode($this->assign['content']['body_waiting']) ) ;
		$editor_assigns = $this->getEditorAssigns( 'body' , $this->assign['content']['body_waiting_raw'] ) ;
    } elseif(($content_data['visible'] == 0) and ($content_data['approval'] == 0)){
        // 新規承認申請中の時
        $editor_assigns = $this->getEditorAssigns( 'body' , $this->assign['content']['body_waiting_raw'] ) ;
	} else {
		$editor_assigns = $this->getEditorAssigns( 'body' , $this->assign['content']['body_raw'] ) ;
	}
	$this->assign['body_wysiwyg'] = $editor_assigns['body'] ;
    $this->assign['content_visible'] = $content_data['visible'];
   
	$this->html_header .= $editor_assigns['header'] ;
}


// virtual
function processPreview()
{
}


function getEditorAssigns( $name , $value )
{
	if( empty( $_POST['body_editor'] ) ) {
		$editor = $this->mod_config['body_editor'] ;
	} else {
		$editor = $_POST['body_editor'] ;
	}

	if( $editor == 'common_fckeditor' ) {
		// FCKeditor in common/fckeditor/
		$header = '
			<script type="text/javascript" src="'.XOOPS_URL.'/common/fckeditor/fckeditor.js"></script>
			<script type="text/javascript"><!--
				function fckeditor_exec() {
					var oFCKeditor = new FCKeditor( "'.$name.'" , "100%" , "500" , "Default" );
					
					oFCKeditor.BasePath = "'.XOOPS_URL.'/common/fckeditor/";
					
					oFCKeditor.ReplaceTextarea();
				}
			// --></script>
		' ;
		$body = '<textarea id="'.$name.'" name="'.$name.'">'.htmlspecialchars($value,ENT_QUOTES).'</textarea><script>fckeditor_exec();</script>' ;
	} else {
		// normal (xoopsdhtmltarea)
		$header = '' ;
		$body = '' ;
	}

	return array( 'header' => $header , 'body' => $body ) ;
}


}

?>