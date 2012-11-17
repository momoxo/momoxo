Lecat
=====
Leimg is category management module for other modules.
Module developers can use this module for handle category and permission control.
Module developer can get category tree and can check permission about user group, category id and action(view/edit/manage/etc.)

Environment
-----------
KARIMOJI 2.2 or later.

Setup
-----
You must make at least one category.

Main Feature
------------
- Category management(create/edit/list/view/delete)
- Manage tree like category.
- Permission management about each category, inherit parent's permission to descendant categories. A descendant category can overwrite these permission.

Client Module
-------------
Modules using this category management functions are called "(category) client (module)".
Client modules must implement Xcore_iCategoryClientDelegate interface in (html)/modules/xcore/class/interface/CatClientDelegateInterface.class.php

Then, they can use this module's delegate functions of Lecat_DelegateFunctions class in (trust_path)/modules/lecat/class/DelegateFunctions.class.php.
  Xcore_Category.(dirname).GetTitle
  Xcore_Category.(dirname).GetTree
  Xcore_Category.(dirname).GetTitleList
  Xcore_Category.(dirname).HasPermission
  Xcore_Category.(dirname).GetParent
  Xcore_Category.(dirname).GetChildren
  Xcore_Category.(dirname).GetCatPath
  Xcore_Category.(dirname).GetPermittedIdList


Update History
--------------
ver 2.01
- Check client data existence before delete the category.

