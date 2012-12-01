<?php
// TODO >> このファイルはクラス名の移行が完了したら削除する

use XCore\Kernel\DelegateManager;

call_user_func(function(){
	$legacyClasses = array(
		'AbstractXoopsObject'                  => null,
		'XCube_AbstractArrayProperty'          => null,
		'XCube_AbstractPermissionProvider'     => null,
		'XCube_AbstractProperty'               => null,
		'XCube_AbstractRequest'                => null,
		'XCube_AbstractServiceClient'          => null,
		'XCube_ActionFilter'                   => null,
		'XCube_ActionForm'                     => null,
		'XCube_BoolArrayProperty'              => null,
		'XCube_BoolProperty'                   => null,
		'XCube_Delegate'                       => null,
		'XCube_DelegateUtils'                  => null,
		'XCube_DependClassFactory'             => null,
		'XCube_EmailValidator'                 => null,
		'XCube_ExtensionValidator'             => null,
		'XCube_FieldProperty'                  => null,
		'XCube_FileArrayProperty'              => null,
		'XCube_FileProperty'                   => null,
		'XCube_FloatArrayProperty'             => null,
		'XCube_FloatProperty'                  => null,
		'XCube_FormFile'                       => null,
		'XCube_FormImageFile'                  => null,
		'XCube_GenericArrayProperty'           => null,
		'XCube_GenericRequest'                 => null,
		'XCube_HttpContext'                    => null,
		'XCube_HttpRequest'                    => null,
		'XCube_Identity'                       => null,
		'XCube_ImageFileArrayProperty'         => null,
		'XCube_ImageFileProperty'              => null,
		'XCube_IniHandler'                     => null,
		'XCube_IntArrayProperty'               => null,
		'XCube_IntProperty'                    => null,
		'XCube_IntRangeValidator'              => null,
		'XCube_MaskValidator'                  => null,
		'XCube_MaxValidator'                   => null,
		'XCube_MaxfilesizeValidator'           => null,
		'XCube_MaxlengthValidator'             => null,
		'XCube_MinValidator'                   => null,
		'XCube_MinlengthValidator'             => null,
		'XCube_Object'                         => null,
		'XCube_ObjectArray'                    => null,
		'XCube_ObjectExistValidator'           => null,
		'XCube_PageNavigator'                  => null,
		'XCube_Permissions'                    => null,
		'XCube_Principal'                      => null,
		'XCube_PropertyInterface'              => null,
		'XCube_Ref'                            => null,
		'XCube_RenderCache'                    => null,
		'XCube_RenderSystem'                   => null,
		'XCube_RenderTarget'                   => null,
		'XCube_RequiredValidator'              => null,
		'XCube_Role'                           => null,
		'XCube_RoleManager'                    => null,
		'XCube_Root'                           => '\XCore\Kernel\Root',
		'XCube_Service'                        => null,
		'XCube_ServiceClient'                  => null,
		'XCube_ServiceManager'                 => null,
		'XCube_ServiceUtils'                   => null,
		'XCube_Session'                        => null,
		'XCube_StringArrayProperty'            => null,
		'XCube_StringProperty'                 => null,
		'XCube_TextArrayProperty'              => null,
		'XCube_TextFilter'                     => null,
		'XCube_TextProperty'                   => null,
		'XCube_Theme'                          => null,
		'XCube_Utils'                          => null,
		'XCube_Validator'                      => null,
		'LegacyBlock_module_linkHandler'        => null,
		'LegacyBlock_module_linkObject'         => null,
		'LegacyBlockctypeHandler'               => null,
		'LegacyBlockctypeObject'                => null,
		'LegacyColumnsideHandler'               => null,
		'LegacyColumnsideObject'                => null,
		'LegacyCommentHandler'                  => null,
		'LegacyCommentObject'                   => null,
		'LegacyCommentstatusHandler'            => null,
		'LegacyCommentstatusObject'             => null,
		'LegacyGroup_permissionHandler'         => null,
		'LegacyGroup_permissionObject'          => null,
		'LegacyImageHandler'                    => null,
		'LegacyImageObject'                     => null,
		'LegacyImagebodyHandler'                => null,
		'LegacyImagebodyObject'                 => null,
		'LegacyImagecategoryHandler'            => null,
		'LegacyImagecategoryObject'             => null,
		'LegacyModuletplObject'                 => null,
		'LegacyNewblocksHandler'                => null,
		'LegacyNewblocksObject'                 => null,
		'LegacyNon_installation_moduleHandler'  => null,
		'LegacyRender_DelegateFunctions'        => null,
		'LegacySmilesHandler'                   => null,
		'LegacySmilesObject'                    => null,
		'LegacyTheme'                           => null,
		'LegacyThemeHandler'                    => null,
		'LegacyThemeObject'                     => null,
		'LegacyTplfileHandler'                  => null,
		'LegacyTplfileObject'                   => null,
		'LegacyTplsetHandler'                   => null,
		'LegacyTplsetObject'                    => null,
		'LegacyTplsourceHandler'                => null,
		'LegacyTplsourceObject'                 => null,
		'Legacy_AbstractBlockProcedure'         => null,
		'Legacy_AbstractCacheInformation'       => null,
		'Legacy_AbstractCategoryObject'         => null,
		'Legacy_AbstractClientObjectHandler'    => null,
		'Legacy_AbstractCommentAdminEditForm'   => null,
		'Legacy_AbstractControllerStrategy'     => null,
		'Legacy_AbstractDebugger'               => null,
		'Legacy_AbstractDeleteAction'           => null,
		'Legacy_AbstractEditAction'             => null,
		'Legacy_AbstractFilterForm'             => null,
		'Legacy_AbstractGroupObject'            => null,
		'Legacy_AbstractImageObject'            => null,
		'Legacy_AbstractListAction'             => null,
		'Legacy_AbstractModinfoReader'          => null,
		'Legacy_AbstractModule'                 => null,
		'Legacy_AbstractModuleInstallAction'    => null,
		'Legacy_AbstractObject'                 => null,
		'Legacy_AbstractPreferenceEditState'    => null,
		'Legacy_AbstractThemeRenderTarget'      => null,
		'Legacy_ActSearchAction'                => null,
		'Legacy_Action'                         => null,
		'Legacy_ActionForm'                     => null,
		'Legacy_ActionFrame'                    => null,
		'Legacy_ActionSearchArgs'               => null,
		'Legacy_ActionSearchForm'               => null,
		'Legacy_ActionSearchRecord'             => null,
		'Legacy_AdminActionSearch'              => null,
		'Legacy_AdminControllerStrategy'        => null,
		'Legacy_AdminRenderSystem'              => null,
		'Legacy_AdminSideMenu'                  => null,
		'Legacy_AdminSmarty'                    => null,
		'Legacy_AdminSystemCheckPlusPreload'    => null,
		'Legacy_AnonymousIdentity'              => null,
		'Legacy_ApprovalCommentAdminEditForm'   => null,
		'Legacy_ArrayOfInt'                     => null,
		'Legacy_ArrayOfString'                  => null,
		'Legacy_BackendAction'                  => null,
		'Legacy_BlockCacheInformation'          => null,
		'Legacy_BlockEditAction'                => null,
		'Legacy_BlockEditForm'                  => null,
		'Legacy_BlockFilterForm'                => null,
		'Legacy_BlockInfoCollection'            => null,
		'Legacy_BlockInformation'               => null,
		'Legacy_BlockInstallEditAction'         => null,
		'Legacy_BlockInstallEditForm'           => null,
		'Legacy_BlockInstallFilterForm'         => null,
		'Legacy_BlockInstallListAction'         => null,
		'Legacy_BlockListAction'                => null,
		'Legacy_BlockListForm'                  => null,
		'Legacy_BlockProcedure'                 => null,
		'Legacy_BlockProcedureAdapter'          => null,
		'Legacy_BlockUninstallAction'           => null,
		'Legacy_BlockUninstallForm'             => null,
		'Legacy_Cacheclear'                     => null,
		'Legacy_CommentAdminDeleteForm'         => null,
		'Legacy_CommentDeleteAction'            => null,
		'Legacy_CommentEditAction'              => null,
		'Legacy_CommentEditForm'                => null,
		'Legacy_CommentEditForm_Admin'          => null,
		'Legacy_CommentFilterForm'              => null,
		'Legacy_CommentListAction'              => null,
		'Legacy_CommentListForm'                => null,
		'Legacy_CommentViewAction'              => null,
		'Legacy_Controller'                     => null,
		'Legacy_Criteria'                       => null,
		'Legacy_CustomBlockDeleteAction'        => null,
		'Legacy_CustomBlockDeleteForm'          => null,
		'Legacy_CustomBlockEditAction'          => null,
		'Legacy_CustomBlockEditForm'            => null,
		'Legacy_DebuggerManager'                => null,
		'Legacy_DialogRenderTarget'             => null,
		'Legacy_EventFunction'                  => null,
		'Legacy_GenericPrincipal'               => null,
		'Legacy_HeaderScript'                   => null,
		'Legacy_HelpAction'                     => null,
		'Legacy_HelpSmarty'                     => null,
		'Legacy_HtaccessViewAction'             => null,
		'Legacy_HttpContext'                    => null,
		'Legacy_IPbanningFilter'                => null,
		'Legacy_Identity'                       => null,
		'Legacy_ImageAdminCreateForm'           => null,
		'Legacy_ImageAdminDeleteForm'           => null,
		'Legacy_ImageAdminEditForm'             => null,
		'Legacy_ImageCreateAction'              => null,
		'Legacy_ImageDeleteAction'              => null,
		'Legacy_ImageEditAction'                => null,
		'Legacy_ImageFilterForm'                => null,
		'Legacy_ImageListAction'                => null,
		'Legacy_ImageListForm'                  => null,
		'Legacy_ImageUploadAction'              => null,
		'Legacy_ImageUploadForm'                => null,
		'Legacy_ImagecategoryAdminDeleteForm'   => null,
		'Legacy_ImagecategoryAdminEditForm'     => null,
		'Legacy_ImagecategoryAdminNewForm'      => null,
		'Legacy_ImagecategoryDeleteAction'      => null,
		'Legacy_ImagecategoryEditAction'        => null,
		'Legacy_ImagecategoryFilterForm'        => null,
		'Legacy_ImagecategoryListAction'        => null,
		'Legacy_ImagecategoryListForm'          => null,
		'Legacy_IndexRedirector'                => null,
		'Legacy_InstallListAction'              => null,
		'Legacy_InstallWizardAction'            => null,
		'Legacy_InstallWizardForm'              => null,
		'Legacy_LanguageManager'                => null,
		'Legacy_Mailer'                         => null,
		'Legacy_MiscFriendAction'               => null,
		'Legacy_MiscFriendForm'                 => null,
		'Legacy_MiscSmiliesAction'              => null,
		'Legacy_MiscSslloginAction'             => null,
		'Legacy_ModinfoX2DBReader'              => null,
		'Legacy_ModinfoX2FileReader'            => null,
		'Legacy_Module'                         => null,
		'Legacy_ModuleAdapter'                  => null,
		'Legacy_ModuleCacheInformation'         => null,
		'Legacy_ModuleEditAction'               => null,
		'Legacy_ModuleEditForm'                 => null,
		'Legacy_ModuleInfoAction'               => null,
		'Legacy_ModuleInstallAction'            => null,
		'Legacy_ModuleInstallForm'              => null,
		'Legacy_ModuleInstallLog'               => null,
		'Legacy_ModuleInstallUtils'             => null,
		'Legacy_ModuleInstaller'                => null,
		'Legacy_ModuleListAction'               => null,
		'Legacy_ModuleListFilterForm'           => null,
		'Legacy_ModuleListForm'                 => null,
		'Legacy_ModulePhasedUpgrader'           => null,
		'Legacy_ModulePreferenceEditForm'       => null,
		'Legacy_ModulePreferenceEditState'      => null,
		'Legacy_ModuleUninstallAction'          => null,
		'Legacy_ModuleUninstallForm'            => null,
		'Legacy_ModuleUninstaller'              => null,
		'Legacy_ModuleUpdateAction'             => null,
		'Legacy_ModuleUpdateForm'               => null,
		'Legacy_ModuleUpdater'                  => null,
		'Legacy_MysqlDebugger'                  => null,
		'Legacy_NonDebugger'                    => null,
		'Legacy_NotifyCancelAction'             => null,
		'Legacy_NotifyDeleteAction'             => null,
		'Legacy_NotifyDeleteForm'               => null,
		'Legacy_NotifyListAction'               => null,
		'Legacy_NuSoapLoader'                   => null,
		'Legacy_PHPDebugger'                    => null,
		'Legacy_PendingCommentAdminEditForm'    => null,
		'Legacy_PreferenceEditAction'           => null,
		'Legacy_PreferenceEditForm'             => null,
		'Legacy_PreferenceEditState'            => null,
		'Legacy_PreferenceInfoCollection'       => null,
		'Legacy_PreferenceInformation'          => null,
		'Legacy_PreferenceListAction'           => null,
		'Legacy_PreferenceOptionInfoCollection' => null,
		'Legacy_PreferenceOptionInformation'    => null,
		'Legacy_PublicControllerStrategy'       => null,
		'Legacy_RenderSystem'                   => null,
		'Legacy_RenderTargetMain'               => null,
		'Legacy_ResourcedbUtils'                => null,
		'Legacy_RoleManager'                    => null,
		'Legacy_SQLScanner'                     => null,
		'Legacy_SearchAction'                   => null,
		'Legacy_SearchItem'                     => null,
		'Legacy_SearchItemArray'                => null,
		'Legacy_SearchModule'                   => null,
		'Legacy_SearchModuleArray'              => null,
		'Legacy_SearchModuleResult'             => null,
		'Legacy_SearchModuleResultArray'        => null,
		'Legacy_SearchResultsAction'            => null,
		'Legacy_SearchResultsForm'              => null,
		'Legacy_SearchService'                  => null,
		'Legacy_SearchShowallAction'            => null,
		'Legacy_SearchShowallForm'              => null,
		'Legacy_SearchShowallbyuserAction'      => null,
		'Legacy_SearchShowallbyuserForm'        => null,
		'Legacy_SearchUtils'                    => null,
		'Legacy_SessionCallback'                => null,
		'Legacy_SiteClose'                      => null,
		'Legacy_SmartyDebugger'                 => null,
		'Legacy_SmilesAdminDeleteForm'          => null,
		'Legacy_SmilesAdminEditForm'            => null,
		'Legacy_SmilesDeleteAction'             => null,
		'Legacy_SmilesEditAction'               => null,
		'Legacy_SmilesFilterForm'               => null,
		'Legacy_SmilesListAction'               => null,
		'Legacy_SmilesListForm'                 => null,
		'Legacy_SmilesUploadAction'             => null,
		'Legacy_SmilesUploadForm'               => null,
		'Legacy_StartupXoopsTpl'                => null,
		'Legacy_SystemModuleInstall'            => null,
		'Legacy_TextFilter'                     => null,
		'Legacy_TextareaEditor'                 => null,
		'Legacy_ThemeListAction'                => null,
		'Legacy_ThemeRenderTarget'              => null,
		'Legacy_ThemeSelect'                    => null,
		'Legacy_ThemeSelectForm'                => null,
		'Legacy_TplfileAdminDeleteForm'         => null,
		'Legacy_TplfileCloneAction'             => null,
		'Legacy_TplfileCloneForm'               => null,
		'Legacy_TplfileDeleteAction'            => null,
		'Legacy_TplfileDownloadAction'          => null,
		'Legacy_TplfileEditAction'              => null,
		'Legacy_TplfileEditForm'                => null,
		'Legacy_TplfileFilterForm'              => null,
		'Legacy_TplfileListAction'              => null,
		'Legacy_TplfileSetFilterForm'           => null,
		'Legacy_TplfileUploadForm'              => null,
		'Legacy_TplfileViewAction'              => null,
		'Legacy_TplsetCloneAction'              => null,
		'Legacy_TplsetCloneForm'                => null,
		'Legacy_TplsetDeleteAction'             => null,
		'Legacy_TplsetDeleteForm'               => null,
		'Legacy_TplsetDownloadAction'           => null,
		'Legacy_TplsetEditAction'               => null,
		'Legacy_TplsetEditForm'                 => null,
		'Legacy_TplsetFilterForm'               => null,
		'Legacy_TplsetListAction'               => null,
		'Legacy_TplsetSelectForm'               => null,
		'Legacy_TplsetUploadAction'             => null,
		'Legacy_TplsetUploadForm'               => null,
		'Legacy_Utils'                          => null,
		'Legacy_Waiting'                        => null,
		'Legacy_XoopsTpl'                       => null,
		'Legacy_iActivityClientDelegate'        => null,
		'Legacy_iActivityDelegate'              => null,
		'Legacy_iCategoryClientDelegate'        => null,
		'Legacy_iCategoryDelegate'              => null,
		'Legacy_iCommentClientDelegate'         => null,
		'Legacy_iCommentDelegate'               => null,
		'Legacy_iGroupClientDelegate'           => null,
		'Legacy_iGroupDelegate'                 => null,
		'Legacy_iImageClientDelegate'           => null,
		'Legacy_iImageDelegate'                 => null,
		'Legacy_iTagClientDelegate'             => null,
		'Legacy_iTagDelegate'                   => null,
		'Legacy_iWorkflowClientDelegate'        => null,
		'Legacy_iWorkflowDelegate'              => null,
		'XoopsApi'                             => null,
		'XoopsAvatar'                          => null,
		'XoopsAvatarHandler'                   => null,
		'XoopsBlock'                           => null,
		'XoopsBlockHandler'                    => null,
		'XoopsCachetime'                       => null,
		'XoopsCachetimeHandler'                => null,
		'XoopsComment'                         => null,
		'XoopsCommentHandler'                  => null,
		'XoopsCommentRenderer'                 => null,
		'XoopsComments'                        => null,
		'XoopsConfigCategory'                  => null,
		'XoopsConfigCategoryHandler'           => null,
		'XoopsConfigHandler'                   => null,
		'XoopsConfigItem'                      => null,
		'XoopsConfigItemHandler'               => null,
		'XoopsConfigOption'                    => null,
		'XoopsConfigOptionHandler'             => null,
		'XoopsDatabase'                        => null,
		'XoopsDatabaseFactory'                 => null,
		'XoopsDownloader'                      => null,
		'XoopsErrorHandler'                    => null,
		'XoopsForm'                            => null,
		'XoopsFormBreak'                       => null,
		'XoopsFormButton'                      => null,
		'XoopsFormCheckBox'                    => null,
		'XoopsFormDateTime'                    => null,
		'XoopsFormDhtmlTextArea'               => null,
		'XoopsFormElement'                     => null,
		'XoopsFormElementTray'                 => null,
		'XoopsFormFile'                        => null,
		'XoopsFormHidden'                      => null,
		'XoopsFormHiddenToken'                 => null,
		'XoopsFormLabel'                       => null,
		'XoopsFormPassword'                    => null,
		'XoopsFormRadio'                       => null,
		'XoopsFormRadioYN'                     => null,
		'XoopsFormSelect'                      => null,
		'XoopsFormSelectCountry'               => null,
		'XoopsFormSelectGroup'                 => null,
		'XoopsFormSelectLang'                  => null,
		'XoopsFormSelectMatchOption'           => null,
		'XoopsFormSelectTheme'                 => null,
		'XoopsFormSelectTimezone'              => null,
		'XoopsFormSelectUser'                  => null,
		'XoopsFormText'                        => null,
		'XoopsFormTextArea'                    => null,
		'XoopsFormTextDateSelect'              => null,
		'XoopsFormToken'                       => null,
		'XoopsGroup'                           => null,
		'XoopsGroupFormCheckBox'               => null,
		'XoopsGroupHandler'                    => null,
		'XoopsGroupPerm'                       => null,
		'XoopsGroupPermForm'                   => null,
		'XoopsGroupPermHandler'                => null,
		'XoopsGuestUser'                       => null,
		'XoopsImage'                           => null,
		'XoopsImageHandler'                    => null,
		'XoopsImagecategory'                   => null,
		'XoopsImagecategoryHandler'            => null,
		'XoopsImageset'                        => null,
		'XoopsImagesetHandler'                 => null,
		'XoopsImagesetimg'                     => null,
		'XoopsImagesetimgHandler'              => null,
		'XoopsLists'                           => null,
		'XoopsLogger'                          => null,
		'XoopsMailer'                          => null,
		'XoopsMediaUploader'                   => null,
		'XoopsMemberHandler'                   => null,
		'XoopsMembership'                      => null,
		'XoopsMembershipHandler'               => null,
		'XoopsModule'                          => null,
		'XoopsModuleHandler'                   => null,
		'XoopsMultiMailer'                     => null,
		'XoopsMultiTokenHandler'               => null,
		'XoopsMySQLDatabase'                   => null,
		'XoopsMySQLDatabaseProxy'              => null,
		'XoopsMySQLDatabaseSafe'               => null,
		'XoopsNotification'                    => null,
		'XoopsNotificationHandler'             => null,
		'XoopsObject'                          => null,
		'XoopsObjectGenericHandler'            => null,
		'XoopsObjectHandler'                   => null,
		'XoopsObjectTree'                      => null,
		'XoopsOnlineHandler'                   => null,
		'XoopsPageNav'                         => null,
		'XoopsPrivmessage'                     => null,
		'XoopsPrivmessageHandler'              => null,
		'XoopsSecurity'                        => null,
		'XoopsSessionHandler'                  => null,
		'XoopsSimpleForm'                      => null,
		'XoopsSimpleObject'                    => null,
		'XoopsSingleTokenHandler'              => null,
		'XoopsStory'                           => null,
		'XoopsSubjecticon'                     => null,
		'XoopsSubjecticonHandler'              => null,
		'XoopsTableForm'                       => null,
		'XoopsTarDownloader'                   => null,
		'XoopsThemeForm'                       => null,
		'XoopsThemeSetParser'                  => null,
		'XoopsTimezone'                        => null,
		'XoopsTimezoneHandler'                 => null,
		'XoopsToken'                           => null,
		'XoopsTokenHandler'                    => null,
		'XoopsTopic'                           => null,
		'XoopsTpl'                             => null,
		'XoopsTplfile'                         => null,
		'XoopsTplfileHandler'                  => null,
		'XoopsTplset'                          => null,
		'XoopsTplsetHandler'                   => null,
		'XoopsTree'                            => null,
		'XoopsUser'                            => null,
		'XoopsUserHandler'                     => null,
		'XoopsXmlRpcApi'                       => null,
		'XoopsXmlRpcArray'                     => null,
		'XoopsXmlRpcBase64'                    => null,
		'XoopsXmlRpcBoolean'                   => null,
		'XoopsXmlRpcDatetime'                  => null,
		'XoopsXmlRpcDocument'                  => null,
		'XoopsXmlRpcDouble'                    => null,
		'XoopsXmlRpcFault'                     => null,
		'XoopsXmlRpcInt'                       => null,
		'XoopsXmlRpcParser'                    => null,
		'XoopsXmlRpcRequest'                   => null,
		'XoopsXmlRpcResponse'                  => null,
		'XoopsXmlRpcString'                    => null,
		'XoopsXmlRpcStruct'                    => null,
		'XoopsXmlRpcTag'                       => null,
		'XoopsXmlRss2Parser'                   => null,
		'XoopsZipDownloader'                   => null,
		'Criteria'                             => null,
		'CriteriaCompo'                        => null,
		'CriteriaElement'                      => null,
		'Database'                             => null,
		'ErrorHandler'                         => null,
	);

	foreach ( $legacyClasses as $oldClassName => $newClassName ) {
		if ( $newClassName === null ) {
			continue;
		}

		class_alias($newClassName, $oldClassName);
	}
});

