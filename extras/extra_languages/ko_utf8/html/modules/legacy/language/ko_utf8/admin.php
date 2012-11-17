<?php
// CONTROL PANEL
define('_AD_LEGACY_MYSQLVERSION', "MYSQL 버전");
define('_AD_LEGACY_OS', "운영체제");
define('_AD_LEGACY_PHPSETTING', "PHP 설정");
define('_AD_LEGACY_PHPSETTING_CRL', "Curl extension");
define('_AD_LEGACY_PHPSETTING_DE', "Display Errors");
define('_AD_LEGACY_PHPSETTING_DOM', "Dom extension");
define('_AD_LEGACY_PHPSETTING_EXIF', "Exif extension");
define('_AD_LEGACY_PHPSETTING_FU', "File Uploads");
define('_AD_LEGACY_PHPSETTING_FU_UMAX', "Upload Max File Size:");
define('_AD_LEGACY_PHPSETTING_FU_PMAX', "Post Max Size:");
define('_AD_LEGACY_PHPSETTING_GD', "GD extension");
define('_AD_LEGACY_PHPSETTING_GTXT', "Gettext extension");
define('_AD_LEGACY_PHPSETTING_JSON', "JSON extension");
define('_AD_LEGACY_PHPSETTING_MET', "Max. execution time");
define('_AD_LEGACY_PHPSETTING_ML', "Memory Limit");
define('_AD_LEGACY_PHPSETTING_MQ', "Magic Quotes");
define('_AD_LEGACY_PHPSETTING_OB', "Output Buffering");
define('_AD_LEGACY_PHPSETTING_OBD', "Open BaseDir");
define('_AD_LEGACY_PHPSETTING_RG', "Register Globals");
define('_AD_LEGACY_PHPSETTING_SAS', "Session auto start");
define('_AD_LEGACY_PHPSETTING_SM', "Safe Mode");
define('_AD_LEGACY_PHPSETTING_SOAP', "Soap extension");
define('_AD_LEGACY_PHPSETTING_SOT', "Short Open Tags");
define('_AD_LEGACY_PHPSETTING_UFO', "Allow url_fopen");
define('_AD_LEGACY_PHPSETTING_XML', "XML enabled");
define('_AD_LEGACY_PHPSETTING_ZLIB', "Zlib enabled");
define('_AD_LEGACY_PHPSETTING_MB', "Mbstring enabled");
define('_AD_LEGACY_PHPSETTING_ICONV', "Iconv available");
define('_AD_LEGACY_PHPSETTING_ON', "On");
define('_AD_LEGACY_PHPSETTING_OFF', "Off");
define('_AD_LEGACY_PHPVERSION', "PHP 버전");
define('_AD_LEGACY_SERVER', "Server");
define('_AD_LEGACY_SYSTEMINFO', "Site/System Info");
define('_AD_LEGACY_USERAGENT', "User Agent");
define('_AD_LEGACY_XCLEGACYVERSION', "XC KARIMOJI_LEGALEGA버전");
define('_AD_LEGACY_XCVERSION', "XOOPS Cube 버전");

// ERROR
define('_AD_LEGACY_ERROR_ACTION_SEARCH_NORESULT', "입력하신 키워드로는 검색결과를 얻을 수 없었습니다.");
define('_AD_LEGACY_ERROR_ACTION_SEARCH_TRY_AGAIN', "키워드를 변경하여 다시 검색해보시기 바랍니다.");
define('_AD_LEGACY_ERROR_BLOCK_TEMPLATE_INSTALL', "블록 템플릿 '{0}' 의 인스톨에 실패하였습니다.");
define('_AD_LEGACY_ERROR_BMODULE', "표시대상 모듈을 하나이상 지정해 주세요!");
define('_AD_LEGACY_ERROR_CASE_OF_ACTIVE_MODULE', "활성화 상태의 모듈은 언인스톨(제거)하실 수 없습니다. 언인스톨(제거)하시려면 먼저 해당 모듈을 비활성화처리 해주시기 바랍니다.");
define('_AD_LEGACY_ERROR_COULD_NOT_ADD_TRUST_DIRNAME', "Could not add trust_dirname in '{0}'.");
define('_AD_LEGACY_ERROR_COULD_NOT_DELETE_BLOCK_TEMPLATES', "블록 템플릿의 삭제에 실패하였습니다: {0}");
define('_AD_LEGACY_ERROR_COULD_NOT_DELETE_DUPLICATE_DATA', "중복된 데이타의 삭제에 실패하였습니다 : {0}");
define('_AD_LEGACY_ERROR_COULD_NOT_EXTEND_CONFIG_TITLE_SIZE', "Could not extend config_table size in '{0}'.");
define('_AD_LEGACY_ERROR_COULD_NOT_INSERT_CONFIG', "설정값 '{0}' 의 삽입에 실패하였습니다.");
define('_AD_LEGACY_ERROR_COULD_NOT_INSTALL_BLOCK', "블록 '{0}' 의 인스톨에 실패하였습니다.");
define('_AD_LEGACY_ERROR_COULD_NOT_INSTALL_TEMPLATE', "템플릿 '{0}' 의 설치에 실패하였습니다.");
define('_AD_LEGACY_ERROR_COULD_NOT_SAVE_SMILES_FILE', "얼굴아이콘 '{0}' 의 저장에 실패하였습니다.");
define('_AD_LEGACY_ERROR_COULD_NOT_SET_ADMIN_PERMISSION', "관리권한 설정에 실패하였습니다.");
define('_AD_LEGACY_ERROR_COULD_NOT_SET_BLOCK_PERMISSION', "'{0}' 블록의 액세스권한 설정에 실패하였습니다.");
define('_AD_LEGACY_ERROR_COULD_NOT_SET_LINK', "'{0}' 블록에 대한 각 모듈과의 링크설정에 실패하였습니다.");
define('_AD_LEGACY_ERROR_COULD_NOT_SET_READ_PERMISSION', "액세스권한 설정에 실패하였습니다.");
define('_AD_LEGACY_ERROR_COULD_NOT_SET_SYSTEM_PERMISSION', "시스템관리권한 설정에 실패하였습니다.");
define('_AD_LEGACY_ERROR_COULD_NOT_SET_UNIQUE_KEY', "'{0}'테이블에 UNIQUE KEY를 설정하는 작업에 실패하였습니다.");
define('_AD_LEGACY_ERROR_DELETE_MODULEINFO_FROM_DB', "데이타베이스에서 모듈정보를 삭제하는 작업에 실패하였습니다.");
define('_AD_LEGACY_ERROR_DROP_TABLE', "테이블 {0} 의 Drop 에 실패하였습니다.");
define('_AD_LEGACY_ERROR_EXTENSION', "허가된 파일형식이 아닙니다.");
define('_AD_LEGACY_ERROR_FAILED_TO_EXECUTE_CALLBACK', "Callback '{0}' 의 실행처리에 실패하였습니다.");
define('_AD_LEGACY_ERROR_GROUPID', "최소 하나이상의 그룹에 액세스권한을 부여해 주세요!");
define('_AD_LEGACY_ERROR_IMG_FILESIZE', "그림파일의 최대파일사이즈는 {0}바이트입니다.");
define('_AD_LEGACY_ERROR_IMG_SIZE', "그림파일의 최대 사이즈는 {0} x {1}입니다.");
define('_AD_LEGACY_ERROR_IMGCAT_READ_GROUPS', "최저 하나이상의 그룹에 사용권한을 부여해 주세요!");
define('_AD_LEGACY_ERROR_INSTALLATION_MODULE_FAILURE', "'{0}' 모듈의 설치에 실패하였습니다.");
define('_AD_LEGACY_ERROR_INTRANGE', "{0} 값은 올바르지 않습니다.");
define('_AD_LEGACY_ERROR_MIN', "{0} 는  {1} 이상의 수치로 지정해 주세요!");
define('_AD_LEGACY_ERROR_MODULE_NOT_FOUND', "지정하신 모듈을 발견하지 못했습니다.");
define('_AD_LEGACY_ERROR_NO_HELP_FILE', "Help 파일을 찾을 수가 없습니다.");
define('_AD_LEGACY_ERROR_OBJECTEXIST', "{0} 값은 올바르지 않습니다.");
define('_AD_LEGACY_ERROR_PLEASE_AGREE', "다음의 라이센스에 동의하여 주세요!");
define('_AD_LEGACY_ERROR_READGROUPS', "최저 하나이상의 그룹에 사용권한을 부여해 주세요!");
define('_AD_LEGACY_ERROR_SEARCH_REQUIRED', "키워드를 입력해 주세요!");
define('_AD_LEGACY_ERROR_SQL_FILE_NOT_FOUND', "{0} 에서 SQL파일을 찾을 수가 없습니다.");
define('_AD_LEGACY_ERROR_TEMPLATE_UNINSTALLED', "템플릿 '{0}' 의 언인스톨(제거)에 실패하였습니다.");
define('_AD_LEGACY_ERROR_UNINSTALLATION_MODULE_FAILURE', "'{0}' 모듈의 언인스톨(제거)에 실패하였습니다.");
define('_AD_LEGACY_ERROR_UPDATING_MODULE_FAILURE', "'{0}' 모듈의 업그레이드에 실패하였습니다.");
define('_AD_LEGACY_ERROR_UPLOADGROUPS', "최저 하나이상의 그룹에 업로드권한을 부여해 주세요!");
define('_AD_LEGACY_ERROR_COULD_NOT_SAVE_IMAGE_FILE', "이미지 '{0}' 의 저장에 실패하였습니다.");
define('_AD_LEGACY_ERROR_DBUPDATE_FAILED', "데이타베이스 갱신에 실패하였습니다.");
define('_AD_LEGACY_ERROR_EXTENSION_IS_WRONG', "업로드 파일의 확장자가 올바르지 않습니다.");
define('_AD_LEGACY_ERROR_REQUIRED', "{0} 은 필수입니다.");

// LANG
define('_AD_LEGACY_LANG_ACTIONSEARCH', "Action Search");
define('_AD_LEGACY_LANG_ACTIONSEARCH_INFO', "입력하신 키워드로 관리메뉴 또는 Help 파일을 검색합니다. <br />관리메뉴의 위치를 잊으신 경우 사용하시면 편리합니다.");
define('_AD_LEGACY_LANG_ACTIVE', "활성화");
define('_AD_LEGACY_LANG_ADD_CUSTOM_BLOCK', "커스텀 블록 추가");
define('_AD_LEGACY_LANG_ADMIN_MENU', "관리메뉴 정보");
define('_AD_LEGACY_LANG_ADMINMENU_HAS_MAIN', "관리메뉴");
define('_AD_LEGACY_LANG_ADMINMENU_INDEX', "관리메뉴 페이지");
define('_AD_LEGACY_LANG_ADMINMENU_MENU', "관리메뉴 설정파일");
define('_AD_LEGACY_LANG_ADMINMENU_NAME', "관리메뉴명");
define('_AD_LEGACY_LANG_ADMINMENU_URL', "관리메뉴 URL");
define('_AD_LEGACY_LANG_AGREE', "동의");
//define('_AD_LEGACY_LANG_ALL_MODULE', "모든 모듈");
define('_AD_LEGACY_LANG_ALL_MODULES', "모든 모듈");
define('_AD_LEGACY_LANG_ALL_STATUS', "모든 상태(status)");
define('_AD_LEGACY_LANG_AUTHOR', "제작자");
define('_AD_LEGACY_LANG_BCACHETIME', "캐쉬 타임");
define('_AD_LEGACY_LANG_BID', "BID");
define('_AD_LEGACY_LANG_BLOCK_EDIT', "블록 편집");
define('_AD_LEGACY_LANG_BLOCK_INSTALL', "블록 인스톨");
define('_AD_LEGACY_LANG_BLOCK_KEY', "키(Key)");
define('_AD_LEGACY_LANG_BLOCK_MOD', "모듈");
define('_AD_LEGACY_LANG_BLOCK_TYPE', "블록 타입");
define('_AD_LEGACY_LANG_BLOCK_UNINSTALL', "블록 언인스톨");
define('_AD_LEGACY_LANG_BLOCK_VAL', "값(Value)");
define('_AD_LEGACY_LANG_BLOCKS_INFO', "블록정보");
define('_AD_LEGACY_LANG_BLOCK_TOTAL', "블록 총계");
define('_AD_LEGACY_LANG_BLOCK_INSTALLEDTOTAL', "설치");
define('_AD_LEGACY_LANG_BLOCK_UNINSTALLEDTOTAL', "비설치");
define('_AD_LEGACY_LANG_BLOCK_ACTIVETOTAL', "활성화");
define('_AD_LEGACY_LANG_BLOCK_INACTIVETOTAL', "비활성화");
define('_AD_LEGACY_LANG_BLOCK_UPDATECONF', "블록 업데이트 확인");
define('_AD_LEGACY_LANG_C_TYPE', "타입");
define('_AD_LEGACY_LANG_CENTER_BLOCK_CENTER', "중앙 블록 - 중앙");
define('_AD_LEGACY_LANG_CENTER_BLOCK_LEFT', "중앙 블록 - 왼쪽");
define('_AD_LEGACY_LANG_CENTER_BLOCK_RIGHT', "중앙 블록 - 오른쪽");
define('_AD_LEGACY_LANG_COM_CREATED', "작성일시");
define('_AD_LEGACY_LANG_COM_MODIFIED', "편집일시");
define('_AD_LEGACY_LANG_COM_SIG', "서명");
define('_AD_LEGACY_LANG_COM_STATUS', "상태");
define('_AD_LEGACY_LANG_COM_UID', "UID");
define('_AD_LEGACY_LANG_COMMENT_DELETE', "코멘트 삭제");
define('_AD_LEGACY_LANG_COMMENT_EDIT', "코멘트 편집");
define('_AD_LEGACY_LANG_COMMENT_NEW', "코멘트 신규 작성");
define('_AD_LEGACY_LANG_COMMENT_TOTAL', "코멘트 총계");
define('_AD_LEGACY_LANG_COMMENT_SVC', "코멘트 기능");
define('_AD_LEGACY_LANG_COMMENT_UPDATECONF', "코멘트 업그레이드 확인");
define('_AD_LEGACY_LANG_COMMENT_VIEW', "코멘트 열람");
define('_AD_LEGACY_LANG_CONFCAT_ID', "Config 카테고리 ID");
define('_AD_LEGACY_LANG_CONFCAT_NAME', "Config 카테고리명");
define('_AD_LEGACY_LANG_CONFIG_INFO', "일반설정정보");
define('_AD_LEGACY_LANG_CONFIG_KEY', "키(Key)");
define('_AD_LEGACY_LANG_CONFIG_VAL', "값(Value)");
define('_AD_LEGACY_LANG_CONTENT', "콘텐츠");
define('_AD_LEGACY_LANG_CONTROL', "조작");
define('_AD_LEGACY_LANG_CREATE_NEW', "신규작성");
define('_AD_LEGACY_LANG_CTYPE_HTML', "HTML태그");
define('_AD_LEGACY_LANG_CTYPE_PHP', "PHP스크립트");
define('_AD_LEGACY_LANG_CTYPE_WITH_SMILIES', "자동 포맷(얼굴아이콘 유효)");
define('_AD_LEGACY_LANG_CTYPE_WITHOUT_SMILIES', "자동 포맷(얼굴아이콘 무효)");
define('_AD_LEGACY_LANG_CUSTOM_HTML', "커스텀(HTML)");
define('_AD_LEGACY_LANG_CUSTOM_PHP', "커스텀(PHP)");
define('_AD_LEGACY_LANG_CUSTOM_WITH_SMILIES', "커스텀(얼굴아이콘 유효)");
define('_AD_LEGACY_LANG_CUSTOM_WITHOUT_SMILIES', "커스텀(얼굴아이콘 무효)");
define('_AD_LEGACY_LANG_CUSTOMBLOCK_DELETE', "커스텀 블록 삭제");
define('_AD_LEGACY_LANG_CUSTOMBLOCK_EDIT', "커스텀 블록 편집");
define('_AD_LEGACY_LANG_DEACTIVATE', "비활성화");
define('_AD_LEGACY_LANG_DIRNAME', "디렉토리 명");
define('_AD_LEGACY_LANG_DISPLAY', "표시");
define('_AD_LEGACY_LANG_DOIMAGE', "[img]태그를 유효화");
define('_AD_LEGACY_LANG_EDIT_FUNC', "편집용 callback 함수");
define('_AD_LEGACY_LANG_FEATURE_SVC_INFO', "중심 기능(feature function)정보");
define('_AD_LEGACY_LANG_FORCE_MODE', "강제 클린업 모드(Force mode): 언인스톨이 정상적으로 되지 않는 경우에도 강제적으로 언인스톨처리하여 불필요한 관련 데이타를 삭제, 가능한 DB를 깨끗한 상태로 만들어줍니다.");
define('_AD_LEGACY_LANG_FORMAT', "형식");
define('_AD_LEGACY_LANG_FUNC_FILE', "Callback함수 정의 파일");
define('_AD_LEGACY_LANG_FUNC_NUM', "함수 번호");
define('_AD_LEGACY_LANG_GET_THE_LATEST_VERSION', "최신버전 가져오기");
define('_AD_LEGACY_LANG_GROUPID', "그룹");
define('_AD_LEGACY_LANG_ID', "ID");
define('_AD_LEGACY_LANG_IMAGE_COUNT', "이미지 수");
define('_AD_LEGACY_LANG_IMAGE_CREATED', "작성일");
define('_AD_LEGACY_LANG_IMAGE_DELETE', "이미지 삭제");
define('_AD_LEGACY_LANG_IMAGE_DISPLAY', "표시");
define('_AD_LEGACY_LANG_IMAGE_EDIT', "이미지 편집");
define('_AD_LEGACY_LANG_IMAGE_ID', "ID");
define('_AD_LEGACY_LANG_IMAGE_LIST', "이미지 리스트");
define('_AD_LEGACY_LANG_IMAGE_NAME', "이미지명");
define('_AD_LEGACY_LANG_IMAGE_NEW', "이미지 신규추가");
define('_AD_LEGACY_LANG_IMAGE_UPDATECONF', "이미지 업데이트 확인");
define('_AD_LEGACY_LANG_IMAGE_UPLOAD', "이미지 일괄 업로드");
define('_AD_LEGACY_LANG_IMAGE_UPLOAD_FILE', "이미지 아카이브(tar.gz 혹은 zip파일만)");
define('_AD_LEGACY_LANG_IMAGE_UPLOAD_RESULT', "이미지 일괄 업로드 결과");
define('_AD_LEGACY_LANG_IMAGE_TOTAL', "이미지 총계");
define('_AD_LEGACY_LANG_IMAGE_DISPLAYTOTAL', "표시 이미지");
define('_AD_LEGACY_LANG_IMAGE_NOTDISPLAYTOTAL', "비표시 이미지");
define('_AD_LEGACY_LANG_IMGCAT_TOTAL', "이미지 카테고리 총계");
define('_AD_LEGACY_LANG_IMGCAT_FILETYPETOTAL', "File 저장 타입");
define('_AD_LEGACY_LANG_IMGCAT_DBTYPETOTAL', "DB 저장 타입");
define('_AD_LEGACY_LANG_IMAGE_WEIGHT', "표시순");
define('_AD_LEGACY_LANG_IMAGECATEGORY_DELETE', "이미지 카테고리 삭제");
define('_AD_LEGACY_LANG_IMAGECATEGORY_EDIT', "이미지 카테고리 편집");
define('_AD_LEGACY_LANG_IMAGECATEGORY_LIST', "이미지 카테고리 리스트");
define('_AD_LEGACY_LANG_IMAGECATEGORY_NEW', "이미지 카테고리 신규추가");
define('_AD_LEGACY_LANG_IMGCAT_UPDATECONF', "이미지 카테고리 업데이트 확인");
define('_AD_LEGACY_LANG_IMGCAT_WRONG', "올바르지 않은 이미지 카테고리!");
define('_AD_LEGACY_LANG_IMGCAT_DISPLAY', "표시");
define('_AD_LEGACY_LANG_IMGCAT_ID', "CID");
define('_AD_LEGACY_LANG_IMGCAT_MAXHEIGHT', "최대높이(px)");
define('_AD_LEGACY_LANG_IMGCAT_MAXSIZE', "최대용량(byte)");
define('_AD_LEGACY_LANG_IMGCAT_MAXWIDTH', "최대폭(px)");
define('_AD_LEGACY_LANG_IMGCAT_NAME', "카테고리명");
define('_AD_LEGACY_LANG_IMGCAT_READ_GROUPS', "이미지 매니져의 사용을 허가할 그룹");
define('_AD_LEGACY_LANG_IMGCAT_STORETYPE', "저장위치");
define('_AD_LEGACY_LANG_IMGCAT_TYPE', "카테고리 타입");
define('_AD_LEGACY_LANG_IMGCAT_UPLOAD_GROUPS', "이미지의 업로드를 허가할 그룹");
define('_AD_LEGACY_LANG_IMGCAT_WEIGHT', "우선순위");
define('_AD_LEGACY_LANG_INFORMATION', "정보");
define('_AD_LEGACY_LANG_INSTALL', "인스톨");
define('_AD_LEGACY_LANG_ISACTIVE', "활성화");
define('_AD_LEGACY_LANG_LAST_MODIFIED', "최종갱신일시");
define('_AD_LEGACY_LANG_LASTUPDATE', "최종갱신일");
define('_AD_LEGACY_LANG_LCR', "왼쪽-중앙-오른쪽");
define('_AD_LEGACY_LANG_LICENCE', "라이센스");
define('_AD_LEGACY_LANG_LIST', "리스트");
define('_AD_LEGACY_LANG_MAINMENU_HAS_MAIN', "메인 메뉴");
define('_AD_LEGACY_LANG_MAINMENU_INFO', "메인메뉴 정보");
define('_AD_LEGACY_LANG_MOD_ADMINGROUP', "타겟 그룹(관리 권한)");
define('_AD_LEGACY_LANG_MOD_AUTHOR', "모듈 제작자");
define('_AD_LEGACY_LANG_MOD_BASIC_INFO', "모듈 기본정보");
define('_AD_LEGACY_LANG_MOD_CREDITS', "서명/메모");
define('_AD_LEGACY_LANG_MOD_DESC', "모듈 설명");
define('_AD_LEGACY_LANG_MOD_DIR_NAME', "모듈 디렉토리명");
define('_AD_LEGACY_LANG_MOD_EDIT', "모듈 편집");
define('_AD_LEGACY_LANG_MOD_LICENSE_INFO', "라이센스 정보 ");
define('_AD_LEGACY_LANG_MOD_MID', "MID");
define('_AD_LEGACY_LANG_MOD_NAME', "모듈명");
define('_AD_LEGACY_LANG_MOD_READGROUP', "타겟 그룹(읽기 권한)");
define('_AD_LEGACY_LANG_MOD_TOTAL', "모듈 총계");
define('_AD_LEGACY_LANG_MODINSTALL', "모듈 설치");
define('_AD_LEGACY_LANG_MODINSTALL_ADVICE', "_%s_을 설치합니다. 계속하시겠습니까?");
define('_AD_LEGACY_LANG_MODINSTALL_CONF', "모듈 설치 확인");
define('_AD_LEGACY_LANG_MODINSTALL_LIST_ADVICE', "보안(Security)을 위해 사용하지 않는 모듈은 서버에서 삭제하시길 권합니다. ");
define('_AD_LEGACY_LANG_MODINSTALL_LOG', "모듈 설치 로그");
define('_AD_LEGACY_LANG_MODINSTALL_SUCCESS', "모듈 설치 완료!");
define('_AD_LEGACY_LANG_MODLIST', "모듈 관리");
define('_AD_LEGACY_LANG_MODULE_LICENSE', "모듈 라이센스");
define('_AD_LEGACY_LANG_MODUNINSTALL_ADVICE', "_%s_을 정말 언인스톨(제거)하시겠습니까?");
define('_AD_LEGACY_LANG_MODUNINSTALL_CONF', "모듈 언인스톨 확인");
define('_AD_LEGACY_LANG_MODUNINSTALL_LOG', "모듈 언인스톨 로그");
define('_AD_LEGACY_LANG_MODUNINSTALL_SUCCESS', "모듈 언인스톨(제거) 완료!");
define('_AD_LEGACY_LANG_MODUPDATE_ADVICE', "_%s_을 정말 업그레이드하시겠습니까?");
define('_AD_LEGACY_LANG_MODUPDATE_CONF', "모듈 업그레이드 확인");
define('_AD_LEGACY_LANG_MODUPDATE_LOG', "모듈 업그레이드 로그");
define('_AD_LEGACY_LANG_MODUPDATE_SUCCESS', "모듈 업그레이드 완료!");
define('_AD_LEGACY_LANG_NAME', "이름");
define('_AD_LEGACY_LANG_NO', "아니요");
define('_AD_LEGACY_LANG_NO_ADMINMENU', "관리메뉴 정보가 설정되어 있지 않습니다.");
define('_AD_LEGACY_LANG_NO_AGREE', "동의하지 않음");
define('_AD_LEGACY_LANG_NO_BLOCK', "블록정보가 설정되어 있지 않습니다.");
define('_AD_LEGACY_LANG_NO_CHANGE', "변경없음");
define('_AD_LEGACY_LANG_NO_CONFIG', "일반설정정보가 설정되어 있지 않습니다.");
define('_AD_LEGACY_LANG_NO_MAINMENU', "메인메뉴 정보가 설정되어 있지 않습니다.");
define('_AD_LEGACY_LANG_NO_SETTING', "No setting: 관리메뉴가 없습니다.");
define('_AD_LEGACY_LANG_NO_SQL', "SQL정보가 설정되어 있지 않습니다.");
define('_AD_LEGACY_LANG_NO_SUBMENU', "서브메뉴가 설정되어 있지 않습니다.");
define('_AD_LEGACY_LANG_NO_TEMPLATE', "템플릿 정보가 설정되어 있지 않습니다.");
define('_AD_LEGACY_LANG_NONE', "없음");
define('_AD_LEGACY_LANG_NOTIF_SVC', "이벤트통지 기능");
define('_AD_LEGACY_LANG_OPTIONS', "옵션");
define('_AD_LEGACY_LANG_PACKAGE', "패키지정보");
define('_AD_LEGACY_LANG_RENDER', "랜더시스템");
define('_AD_LEGACY_LANG_RES_FOR_COMMENT', "이 코멘트에의 댓글");
define('_AD_LEGACY_LANG_RESULT', "검색결과");
define('_AD_LEGACY_LANG_SEARCH', "검색");
define('_AD_LEGACY_LANG_SEARCH_SVC', "검색 기능");
define('_AD_LEGACY_LANG_SELECTED', "선택 상태");
define('_AD_LEGACY_LANG_SMILES_UPLOAD', "얼굴아이콘 일괄 업로드");
define('_AD_LEGACY_LANG_SMILES_UPLOAD_FILE', "얼굴아이콘 아카이브(tar.gz 혹은zip파일만)");
define('_AD_LEGACY_LANG_SMILES_UPLOAD_RESULT', "얼굴아이콘 일괄 업로드 결과");
define('_AD_LEGACY_LANG_SMILES_TOTAL', "얼굴아이콘 총계");
define('_AD_LEGACY_LANG_SMILES_DISPLAYTOTAL', "표시 얼굴아이콘");
define('_AD_LEGACY_LANG_SMILES_NOTDISPLAYTOTAL', "비표시 얼굴아이콘");
define('_AD_LEGACY_LANG_SMILES_UPDATECONF', "얼굴아이콘 업데이트 확인");
define('_AD_LEGACY_LANG_SHOW_FUNC', "표시용 Callback함수");
define('_AD_LEGACY_LANG_SIDE', "표시 Side");
define('_AD_LEGACY_LANG_SIDE_BLOCK_LEFT', "Side 블록 - 왼쪽");
define('_AD_LEGACY_LANG_SIDE_BLOCK_RIGHT', "Side 블록 - 오른쪽");
define('_AD_LEGACY_LANG_SMARTY', "Smarty");
define('_AD_LEGACY_LANG_SMILE_URL', "그림파일");
define('_AD_LEGACY_LANG_SMILES_DELETE', "얼굴아이콘 삭제");
define('_AD_LEGACY_LANG_SMILES_EDIT', "얼굴아이콘 편집");
define('_AD_LEGACY_LANG_SMILES_NEW', "얼굴아이콘 신규추가");
define('_AD_LEGACY_LANG_SQL_ENGINE', "SQL 엔진");
define('_AD_LEGACY_LANG_SQL_FILE_NAME', "SQL 파일명");
define('_AD_LEGACY_LANG_SQL_HAS_MAIN', "SQL 사용");
define('_AD_LEGACY_LANG_SQL_INFO', "SQL 정보");
define('_AD_LEGACY_LANG_SQL_MYSQL', "MySQL");
define('_AD_LEGACY_LANG_SUBMENU_NAME', "서브메뉴 이름");
define('_AD_LEGACY_LANG_SUBMENU_URL', "서브메뉴 URL");
define('_AD_LEGACY_LANG_TABLE_NAME', "테이블 이름");
define('_AD_LEGACY_LANG_TABLE_NUM', "No ");
define('_AD_LEGACY_LANG_TABLE_PROPERTIES', "테이블 구조");
define('_AD_LEGACY_LANG_TARGET_GROUPS', "액세스권한을 가진 그룹");
define('_AD_LEGACY_LANG_TARGET_MODULES', "표시대상 모듈");
define('_AD_LEGACY_LANG_TEMPLATE', "템플릿");
define('_AD_LEGACY_LANG_TEMPLATE_DESC', "템플릿 설명");
define('_AD_LEGACY_LANG_TEMPLATE_ENGINE', "템플릿 엔진");
define('_AD_LEGACY_LANG_TEMPLATE_FILE', "템플릿 파일명");
define('_AD_LEGACY_LANG_TEMPLATE_HAS_MAIN', "템플릿 사용");
define('_AD_LEGACY_LANG_TEMPLATE_INFO', "템플릿 정보");
define('_AD_LEGACY_LANG_TEMPLATE_KEY', "키(Key)");
define('_AD_LEGACY_LANG_THEME', "테마");
define('_AD_LEGACY_LANG_THEME_ADMIN', "테마 관리");
define('_AD_LEGACY_LANG_TITLE', "타이틀");
define('_AD_LEGACY_LANG_TOPPAGE', "톱페이지");
define('_AD_LEGACY_LANG_UNINSTALL', "언인스톨");
define('_AD_LEGACY_LANG_UPDATE', "업데이트");
define('_AD_LEGACY_LANG_UPGRADE', "업그레이드");
define('_AD_LEGACY_LANG_UPLOAD', "업로드");
define('_AD_LEGACY_LANG_VERSION', "버전");
define('_AD_LEGACY_LANG_VISIBLE', "표시");
define('_AD_LEGACY_LANG_WEIGHT', "표시순");

// MESSAGE
define('_AD_LEGACY_MESSAGE_ADD_TRUST_DIRNAME_SUCCESSFUL', "Add trust_dirname in Table '{0}' has been successful.");
define('_AD_LEGACY_MESSAGE_BLOCK_HAS_BEEN_UNINSTALLED', "블록 {0} 을 언인스톨하였습니다.");
define('_AD_LEGACY_MESSAGE_BLOCK_INSTALLED', "블록 {0} 을 인스톨하였습니다.");
define('_AD_LEGACY_MESSAGE_BLOCK_TEMPLATE_INSTALLED', "블록 템플릿 '{0}' 을 인스톨하였습니다.");
define('_AD_LEGACY_MESSAGE_CHILDREN_DELETED_TOGETHER', "함께 삭제된 데이타");
define('_AD_LEGACY_MESSAGE_CONFIRM_UPDATE_IMGCAT', "카테고리를 정말로 업데이트하시겠습니까?");
define('_AD_LEGACY_MESSAGE_CONFIRM_DELETE', "다음 데이타를 정말로 삭제하시겠습니까?");
define('_AD_LEGACY_MESSAGE_CONFIRM_UPDATE_BLOCK', "블록을 정말로 업데이트하시겠습니까?");
define('_AD_LEGACY_MESSAGE_CONFIRM_UPDATE_COMMENT', "코멘트를 정말로 업데이트하시겠습니까?");
define('_AD_LEGACY_MESSAGE_CONFIRM_UPDATE_IMAGE', "이미지를 정말로 업데이트하시겠습니까?");
define('_AD_LEGACY_MESSAGE_CONFIRM_UPDATE_MODULE', "모듈을 정말로 업데이트하시겠습니까?");
define('_AD_LEGACY_MESSAGE_CONFIRM_UPDATE_SMILES', "얼굴아이콘을 정말로 업데이트하시겠습니까?");
define('_AD_LEGACY_MESSAGE_DATABASE_SETUP_FINISHED', "데이타베이스테이블의 셋업을 완료하였습니다.");
define('_AD_LEGACY_MESSAGE_DELETE_MODULEINFO_FROM_DB', "모듈정보를 데이타베이스에서 삭제하였습니다.");
define('_AD_LEGACY_MESSAGE_DROP_TABLE', "테이블 {0} 을 Drop처리하였습니다.");
define('_AD_LEGACY_MESSAGE_EXTEND_CONFIG_TITLE_SIZE_SUCCESSFUL', "Extend config_title size in Table '{0}' has been successful.");
define('_AD_LEGACY_MESSAGE_INSERT_CONFIG', "Config {0} 을 추가하였습니다.");
define('_AD_LEGACY_MESSAGE_INSTALLATION_MODULE_SUCCESSFUL', "'{0}' 모듈의 설치에 성공하였습니다.");
define('_AD_LEGACY_MESSAGE_SET_UNIQUE_KEY_SUCCESSFUL', "'{0}'의 UNIQUE KEY설정작업에 성공하였습니다.");
define('_AD_LEGACY_MESSAGE_TEMPLATE_INSTALLED', "템플릿 '{0}' 을 설치하였습니다.");
define('_AD_LEGACY_MESSAGE_UNINSTALLATION_BLOCK_SUCCESSFUL', "'{0}' 블록의 언인스톨에 성공하였습니다.");
define('_AD_LEGACY_MESSAGE_UNINSTALLATION_MODULE_SUCCESSFUL', "'{0}' 모듈의 언인스톨에 성공하였습니다.");
define('_AD_LEGACY_MESSAGE_UPDATE_STARTED', "업그레이드를 시작합니다.");
define('_AD_LEGACY_MESSAGE_UPDATING_MODULE_SUCCESSFUL', "'{0}' 모듈의 업그레이드에 성공하였습니다.");

// TIPS
define('_AD_LEGACY_TIPS_ADD_CUSTOM_BLOCK', "<a href=\"index.php?action=BlockInstallList\">신규 블록을 설치</a>하셔서 사이트를 멋지게 꾸며보시기 바랍니다.<br/>모듈에 소속된 블록 이외에도 <a href=\"index.php?action=CustomBlockEdit\">커스텀 블록을 추가</a>하셔서 블록에 자유롭게 콘텐츠를 표시하실 수도 있습니다.");
define('_AD_LEGACY_TIPS_BLOCK_UNINSTALL', "Q:블록을 언인스톨하면?<br />블록을 제거(언인스톨)하셔도 실제적으로 삭제되지는 않습니다. 현재의 설정정보를 그대로 유지한 채로 단지 비표시처리될 뿐입니다. 따라서 언제든지 다시 인스톨하셔서 사용하실 수 있습니다.");
define('_AD_LEGACY_TIPS_BLOCK', "<a href=\"index.php?action=CustomBlockEdit\">커스텀 블록</a>을 만들어 블록에 자유롭게 콘텐츠를 표시해 보세요.");
define('_AD_LEGACY_TIPS_BLOCK2', "블록 설치시 각 블록에 대한 옵션을 설정하실 수 있습니다.");
define('_AD_LEGACY_TIPS_COMMENT', "코멘트를 자유롭게 검색하고 손쉽게 관리하실 수 있습니다.");
define('_AD_LEGACY_TIPS_CUSTOM_BLOCK_UNINSTALL', "Q:커스텀 블록을 언인스톨하면?<br />커스텀 블록을 제거(언인스톨)하셔도 실제적으로 삭제되지는 않습니다. 현재의 설정정보를 그대로 유지한 채로 단지 비표시처리되어 미설치블록리스트로 이동되어지게 됩니다. 따라서 미설치블록리스트에서 해당 블록을 찾아 언제든지 삭제 혹은 재인스톨하셔서 사용하실 수 있습니다.");
define('_AD_LEGACY_TIPS_IMAGE', "아카이브 파일 업로드를 통해 다량의 이미지를 손쉽게 일괄 등록처리하실 수 있습니다.)");
define('_AD_LEGACY_TIPS_IMAGE_UPLOAD', "아카이브 파일의 업로드를 통해 다량의 이미지를 일괄 등록처리하실 수 있습니다.<br />미리 각 이미지의 사이즈와 용량을 규격에 맞게 체크한 후에 아카이브 파일을 작성하시기 바랍니다.<br />일괄 등록작업시엔 별도로 체크하지 않으니 꼭 미리 규격에 맞추시기 바랍니다.<br />(tar.gz 혹은 zip파일만)");
define('_AD_LEGACY_TIPS_IMGCAT', "이미지 카테고리를 설정하고 관리하실 수 있습니다.");
define('_AD_LEGACY_TIPS_IMGCAT_STORETYPE', "이미지파일의 저장방식에는 파일시스템에 저장하는 방법과 데이타베이스에 저장하는 방법이 있습니다. 원하시는 방법을 선택해 주세요!(주의: 향후 변경 불가능)<br/>데이타베이스에 저장시에는 BLOB 포맷이 이용되어집니다.");
define('_AD_LEGACY_TIPS_INSTALL_BLOCK', "블록을 인스톨하셔서 사이트를 멋지게 꾸며 보시기 바랍니다.<br />환영메세지 등 원하는 콘텐츠를 표시하시고 싶으실 경우엔 <a href=\"index.php?action=CustomBlockEdit\">커스텀 블록</a>을 이용하시면 됩니다.");
define('_AD_LEGACY_TIPS_PHASED_UPGRADE_MODE', "이것은 Phased Upgrade Mode입니다.최신버전으로 만들기위해 몇번의 업그레이드작업이 필요할 수도 있습니다.단계적으로 업그레이드를 진행함으로써 모듈을 성공적으로 업그레이드하실 수 있습니다.");
define('_AD_LEGACY_TIPS_MOD', "새 모듈을 설치하신 후엔 반드시 해당 모듈관련 일반설정, 블록설정, 권한설정을 하시기 바랍니다.");
define('_AD_LEGACY_TIPS_SMILES', "얼굴아이콘을 손쉽게 관리하실 수 있습니다.");
define('_AD_LEGACY_TIPS_SMILES_UPLOAD', "아카이브 파일의 업로드를 통해 다량의 얼굴아이콘을 일괄 등록처리하실 수 있습니다.<br />미리 각 얼굴아이콘의 사이즈와 용량을 규격에 맞게 체크한 후에 아카이브 파일을 작성하시기 바랍니다.<br />일괄 등록작업시엔 별도로 체크하지 않으니 꼭 미리 규격에 맞추시기 바랍니다.<br />(tar.gz 혹은 zip파일만)");
define('_AD_LEGACY_TIPS_THEME_ADMIN', "선택 버튼을 클릭하셔서 원하는 디자인으로 사이트 테마를 변경해 보시기 바랍니다.<br/>사용자들이 자유롭게 테마를 변경할 수 있게 테마선택블록을 표시하실수도 있습니다. 자세한 사항은 Help를 참고하세요!");

// MODULE ADMIN
define('_MD_AM_ADMINML', "관리자 메일주소");
define('_MD_AM_ADMNOTSET', "관리자 메일이 설정되지 않았습니다.");
define('_MD_AM_ALLOWHTML', "코멘트 문에의 서명 첨가를 허용함 ");
define('_MD_AM_ALLOWIMAGE', "투고문에의 그림파일 표시를 허가함");
define('_MD_AM_ALLOWREG', "신규 회원의 등록을 허용함");
define('_MD_AM_ALLOWREGDSC', "예 를 선택하시면 신규 회원 등록을 허용하게 됩니다.");
define('_MD_AM_ALLOWTHEME', "사용자의 사이트 테마 선택을 허가함");
define('_MD_AM_ALWDHTML', "투고문내에서의 사용을 허락할 HTML태그");
define('_MD_AM_ANONNAME', "미등록방문객(손님)의 표시명");
define('_MD_AM_ANONPOST', "손님의 익명투고를 허용함");
define('_MD_AM_BADIPS', "차단 처리할 IP 주소를 입력해 주세요! 각 IP주소는 | 로 구분, 대소문자 구별하지 않음, 정규식 사용가능");
define('_MD_AM_BADIPSDSC', "^aaa.bbb.ccc 는 aaa.bbb.ccc 로 시작하는 IP주소를 차단,<br />aaa.bbb.ccc$ 는 aaa.bbb.ccc로 끝나는 IP주소를 차단,<br />aaa.bbb.ccc 는 aaa.bbb.ccc 를 포함한 IP주소를 차단합니다.");
define('_MD_AM_CENSOR', "금지용어 설정");
define('_MD_AM_CENSORRPLC', "금지용어 대신 표시할 문자열:");
define('_MD_AM_CENSORRPLCDSC', "금지용어가 있을 경우 이곳에 기입하신 문자열로 대치되게 됩니다.");
define('_MD_AM_CENSORWRD', "금지용어");
define('_MD_AM_CENSORWRDDSC', "사용자가 투고시 사용을 금지할 문자열을 입력해 주세요!<br />각 문자열은 <b>|</b>로 구분, 대소문자 구별하지 않음.");
define('_MD_AM_CHNGUTHEME', "모든 등록회원의 테마를 변경함");
define('_MD_AM_CLOSESITE', "사이트 공개중지");
define('_MD_AM_CLOSESITEDSC', "특정 그룹 이외에는 사이트에 접속하지 못하게 합니다.");
define('_MD_AM_CLOSESITEOK', "사이트 공개중지시에도 접속을 허용할 그룹");
define('_MD_AM_CLOSESITEOKDSC', "기본 관리자그룹은 자동적으로 접속이 허용됩니다.");
define('_MD_AM_CLOSESITETXT', "사이트 공개중지의 이유");
define('_MD_AM_CLOSESITETXTDSC', "입력하신 글은 사이트 공개중지시에 표시되게 됩니다.");
define('_MD_AM_COMMODE', "기본 코멘트 표시방식");
define('_MD_AM_COMORDER', "기본 코멘트 표시순");
define('_MD_AM_DEBUGMODE', "디버그 모드");
define('_MD_AM_DEBUGMODE0', "오프(껌)");
define('_MD_AM_DEBUGMODE1', "PHP 디버그");
define('_MD_AM_DEBUGMODE2', "MySQL/Blocks 디버그");
define('_MD_AM_DEBUGMODE3', "Smarty 템플렛 디버그");
define('_MD_AM_DEBUGMODEDSC', "서버 테스트/디버그 시에 사용하시기 바랍니다. 공개서버에서는 디버그 모드를 오프(껌)로 설정하시기 바랍니다.");
define('_MD_AM_DEFAULTTZ', "기본 시간대");
define('_MD_AM_DOBADIPS', "IP 차단(IP bans) 사용");
define('_MD_AM_DOBADIPSDSC', "해당 IP 주소로부터 이 사이트로의 접속은 차단됩니다.");
define('_MD_AM_DOCENSOR', "금지용어 설정을 사용함");
define('_MD_AM_DOCENSORDSC', "이 기능을 ON(사용)할 경우엔 금지용어를 체크하게 됩니다.(사이트 처리스피드를 중시할 경우엔 OFF로 설정하세요.)");
define('_MD_AM_DONTCHNG', "이하는 절대 변경하지 마시기 바랍니다.");
define('_MD_AM_DOSEARCH', "글로벌 검색기능을 사용함");
define('_MD_AM_DOSEARCHDSC', "사이트내의 투고글/기사등에 대한 전체검색을 실시합니다.");
define('_MD_AM_DTHEME', "기본 사이트 테마");
define('_MD_AM_DTPLSET', "기본 템플렛 세트");
define('_MD_AM_GENERAL', "일반설정");
define('_MD_AM_IFUCANT', "만약 이 파일의 액세스권한을 변경하실 수 없는 경우엔 직접 파일을 편집/수정하셔야만 합니다.");
define('_MD_AM_INVLDMINPASS', "패스워드의 최저문자수가 올바르지 않습니다.");
define('_MD_AM_INVLDSCOOK', "세션ID용 쿠키의 이름이 올바르지 않습니다.");
define('_MD_AM_INVLDSEXP', "세션이 타임아웃될 때까지의 시간이 올바르게 입력되지 않았습니다.");
define('_MD_AM_INVLDUCOOK', "회원 쿠키의 이름이 올바르지 않습니다.");
define('_MD_AM_IPBAN', "IP 차단(IP Banning)");
define('_MD_AM_LANGUAGE', "기본사용언어");
define('_MD_AM_LOADINGIMG', "잠시만 기다려주세요...화면(그림파일)을 표시");
define('_MD_AM_MAILER', "메일 설정");
define('_MD_AM_MAILER_', "");
define('_MD_AM_MAILER_MAIL', "");
define('_MD_AM_MAILER_SENDMAIL', "");
define('_MD_AM_MAILERMETHOD', "메일 전송 방식");
define('_MD_AM_MAILERMETHODDESC', "메일 전송 방식을 선택해 주세요! 기본설정에서는 PHP의 mail()함수가 사용됩니다.");
define('_MD_AM_MAILFROM', "송신자 메일주소");
define('_MD_AM_MAILFROMDESC', "");
define('_MD_AM_MAILFROMNAME', "송신자");
define('_MD_AM_MAILFROMNAMEDESC', "");
define('_MD_AM_MAILFROMUID', "PM쪽지 송신자");
define('_MD_AM_MAILFROMUIDDESC', "PM쪽지를 보낼 때 송신자로서 기본적으로 표시될 사람을 선택해 주세요.");
define('_MD_AM_MINSEARCH', "키워드 최저문자수");
define('_MD_AM_MINSEARCHDSC', "검색을 할 때 필요한 키워드의 최저문자수를 지정합니다.");
define('_MD_AM_MODCACHE', "모듈 캐쉬");
define('_MD_AM_MODCACHEDSC', "각 모듈의 콘텐츠를 캐쉬해 둘 시간의 길이를 지정해 주세요. 모듈에 독자적 캐쉬기능이 있는 경우에는 캐쉬않음 을 선택하실 것을 추천합니다.(블록캐쉬는 포함되지 않습니다.)");
define('_MD_AM_MODCONFIG', "모듈 설정 옵션");
define('_MD_AM_MYIP', "님의 IP 주소를 입력해주세요!");
define('_MD_AM_MYIPDSC', "이 IP 주소는 배너 임프레션 수,그외 기타 사이트 통계시 제외됩니다.");
define('_MD_AM_NO', "아니요");
define('_MD_AM_NOMODULE', "캐쉬가능한 모듈이 존재하지 않습니다.");
define('_MD_AM_NONE', "없음");
define('_MD_AM_NOTIFYTO', "신규 회원 등록 통지/통보 메일을 받을 그룹을 설정해 주세요!");
define('_MD_AM_PERMADDNG', '그룹퍼미션추가에 실패하였습니다.(퍼미션명: %s 해당아이템: %s 해당그룹: %s');
define('_MD_AM_PERMADDNGP', '이 아이템의 상위(부모)아이템 모두에게 퍼미션을 주어야만 합니다.');
define('_MD_AM_PERMADDOK','그룹퍼미션을 추가하였습니다.(퍼미션명: %s 해당아이템: %s 해당그룹: %s');
define('_MD_AM_PERMRESETNG','%s 모듈의 그룹퍼미션 설정초기화에 실패하였습니다.');
define('_MD_AM_PREFMAIN', "시스템 설정 메인");
define('_MD_AM_REMEMBER', "이 파일을 웹상의 관리자메뉴에서 편집가능하게 하려면 반드시 액세스권한을 666(chmod 666)으로 설정하셔야 합니다.");
define('_MD_AM_SEARCH', "검색 옵션");
define('_MD_AM_SENDMAILPATH', "sendmail 경로");
define('_MD_AM_SENDMAILPATHDESC', "sendmail program에의 전체 경로를 기입해 주세요");
define('_MD_AM_SERVERTZ', "서버 시간대");
define('_MD_AM_SESSEXPIRE', "세션이 타임아웃될 때까지의 시간(단위:분)");
define('_MD_AM_SESSEXPIREDSC', "세션이 타임아웃될 때까지의 시간을 분단위로 지정해 주세요! ( 세션 카스트마이즈(자체설정)를 선택한 경우만)");
define('_MD_AM_SESSNAME', "세션ID의 저장에 사용할 쿠키의 이름");
define('_MD_AM_SESSNAMEDSC', "이 쿠키에 저장된 세션ID는 세션이 타임아웃되거나 회원이 로그아웃할 때까지 유효하게됩니다.(세션 카스트마이즈(자체설정)를 선택한 경우만)");
define('_MD_AM_SITECACHE', "사이트 캐쉬");
define('_MD_AM_SITECACHEDSC', "사이트내의 콘텐츠를 모듈별로 캐쉬합니다. 사이트 캐쉬기능은 모듈의 독자적인 캐쉬기능(있는 경우)보다 우선시 됩니다.");
define('_MD_AM_SITENAME', "사이트명");
define('_MD_AM_SITEPREF', "사이트 일반설정");
define('_MD_AM_SLOGAN', "사이트 슬로건");
define('_MD_AM_SMTPHOST', "SMTP 서버 주소");
define('_MD_AM_SMTPHOSTDESC', "SMTP 서버의 주소 목록을 기입해 주세요!");
define('_MD_AM_SMTPPASS', "SMTPAuth 패스워드");
define('_MD_AM_SMTPPASSDESC', "SMTPAuth를 사용해 SMTP서버에 접속시 사용될 패스워드");
define('_MD_AM_SMTPUSER', "SMTPAuth 유저명");
define('_MD_AM_SMTPUSERDESC', "SMTPAuth를 사용해 SMTP서버에 접속시 사용될 유저명");
define('_MD_AM_SSLLINK', "SSL로그인 페이지 URL");
define('_MD_AM_SSLPOST', "SSL로그인시에 사용할 POST변수의 이름");
define('_MD_AM_STARTPAGE', "시작 모듈");
define('_MD_AM_THEMEFILE', "themes/ 디렉토리로부터의 자동 업그레이드기능을 사용");
define('_MD_AM_THEMEFILEDSC', "현재 사용중인 테마보다 갱신일이 더 최근인 파일이 themes/ 디렉토리내에 존재할 경우 자동적으로 DB의 내용을 갱신하게 됩니다. 공개사이트에서는 OFF(껌)로 설정할 것을 추천합니다.");
define('_MD_AM_THEMEOK', "선택가능한 테마");
define('_MD_AM_THEMEOKDSC', "사용자가 기본테마로 선택할 수 있게 할 테마를 선택해 주세요.");
define('_MD_AM_THEMESET', "테마 세트");
define('_MD_AM_USEGZIP', "gzip 압축을 사용");
define('_MD_AM_USEMYSESS', "세션의 설정을 카스트마이즈함(자체설정함)");
define('_MD_AM_USEMYSESSDSC', "세션을 카스트마이즈(자체설정)");
define('_MD_AM_USESSL', "로그인에 SSL을 사용");
define('_MD_AM_YES', "예");

define('_MD_AM_COOLURI', 'Cool URI 사용?');
define('_MD_AM_COOLURIDSC', '이용중인 서버가 mod_rewrite 를 지원한다면 이 옵션을 이용하실 수 있습니다. <a href="'.XOOPS_URL.'/modules/legacyRender/admin/index.php?action=HtaccessView">.htaccess 설정</a>과 연관해 살펴보시기 바랍니다.');

?>