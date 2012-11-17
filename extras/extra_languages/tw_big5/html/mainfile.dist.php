<?php
// $Id: mainfile.dist.php,v 1.1 2008/03/09 02:26:10 minahito Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

if ( !defined("XOOPS_MAINFILE_INCLUDED") ) {
    define("XOOPS_MAINFILE_INCLUDED",1);

	// XOOPS ������|
	// XOOPS�w�˪�������|�̫�ť[�׽u�C
	// �d��: define('XOOPS_ROOT_PATH', '/path/to/xoops/directory');
    	define('XOOPS_ROOT_PATH', '');
	
    	// XOOPS �w�����|
    	// �o�O��ܩʪ����ءA�p�G�z�ݭn�Ψ�п�J�A
    	// �o�Ӹ��|�������w�����s��L�k�����s�����C
    	define('XOOPS_TRUST_PATH', '');

	// XOOPS ���} (URL)
	// �w��XOOPS�����}�̫�ť[�׽u�C
	// �d��: define('XOOPS_URL', 'http://url_to_xoops_directory');
    	define('XOOPS_URL', 'http://');

	// ��Ʈw����
	// ��Ʈw���ϥ�����
	define('XOOPS_DB_TYPE', 'mysql');

	// ��ƪ�e�m��
	// �b�C��XOOPS�ϥΪ���ƪ�e�ҨϥΪ��e�m�ѧO�N��.�p�G�S���S��]�w.�i�ϥιw�]�� 'xoopscube'.
	define('XOOPS_DB_PREFIX', 'xoopscube');

	// �Y�g
	// �o�ӬO���F�ɥR�@�Ψӥͦ��s�X�M�аO�A �z���ݧ��ܹw�]��
    	define('XOOPS_SALT', '');

	// ��Ʈw��A����}
	// XOOPS�ҨϥΪ���Ʈw��A����},�p�G���T�w�i�ϥ� 'localhost' �j�h�ƪ����p�U���ӥi�H�ϥ�.
	define('XOOPS_DB_HOST', 'localhost');

	// ��Ʈw�b��
	// �ϥθ�Ʈw���b��
	define('XOOPS_DB_USER', '');

	// ��Ʈw�K�X
	// ��Ʈw�b���ҨϥΪ��K�X
	define('XOOPS_DB_PASS', '');

	// ��Ʈw�W��
	// XOOPS�ҨϥΪ���Ʈw�W��.�p�G�S����إ�.�w�˵{���|���z�إ�(�n���إ߸�Ʈw�v�����b���K�X)
	define('XOOPS_DB_NAME', '');

	// ��Ʈw�ϥ�Pconnect�Ҧ�? (�O=1 �_=0)
	// �w�]���_.�p�G�����D�п�_
	define('XOOPS_DB_PCONNECT', 0);

	define("XOOPS_GROUP_ADMIN", "1");
	define("XOOPS_GROUP_USERS", "2");
	define("XOOPS_GROUP_ANONYMOUS", "3");

    // You can select two special module process excuting mode with defining following constants
    //
    //  define('_XCORE_PREVENT_LOAD_CORE_', 1);
    //    Module process will not load any XOOPS Cube classes.
    //    You cannot use any XOOPS Cube functions and classes.
    //    (eg. It'll be used for reffering only MySQL Database definition.)
    //
    //  define('_XCORE_PREVENT_EXEC_COMMON_', 1);
    //    Module process will load XOOPS Cube Root class and initialize Controller class.
    //    You can use some XOOPS Cube functions in this mode.
    //    You can use more XOOPS Cube functions (eg. xoops_gethandler), if you write
    //       $root=&XCube_Root::getSingleton();
    //       $root->mController->executeCommonSubset();
    //    after including mainfile.php.
    //    It is synonym of $xoopsOption['nocommon']=1; 
    //    But $xoopsOption['nocommon'] is deprecated.
    //
    if (!defined('_XCORE_PREVENT_LOAD_CORE_') && XOOPS_ROOT_PATH != '') {
        include_once XOOPS_ROOT_PATH.'/modules/xcore/include/cubecore_init.php';
        if (!isset($xoopsOption['nocommon']) && !defined('_XCORE_PREVENT_EXEC_COMMON_')) {
            include XOOPS_ROOT_PATH.'/modules/xcore/include/common.php';
        }
    }
}
?>