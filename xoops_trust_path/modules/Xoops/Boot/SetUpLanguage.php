<?php

namespace Xoops\Boot;

use XCore\Database\Criteria;
use XCore\Database\CriteriaCompo;
use XCore\Kernel\Ref;
use Xcore_LanguageManager;
use Xoops\Boot\BootCommandInterface;
use Xoops\Kernel\ControllerInterface;

/**
 * Creates the instance of Language Manager class, and sets it to member
 * property.
 */
class SetUpLanguage implements BootCommandInterface
{
    /**
     * @var ControllerInterface
     */
    private $controller;

    /**
     * {@inherit}
     */
    public function setController(ControllerInterface $controller)
    {
        $this->controller = $controller;
    }

    /**
     * {@inherit}
     * Now, this member function sets a string to the member property without
     * language manager.
     */
    public function execute()
    {
        $language = null;

        $this->controller->getGetLanguageNameDelegate()->call(new Ref($language));

        if ($language == null) {
            $handler = xoops_gethandler('config');
            $criteria = new CriteriaCompo(new Criteria('conf_modid', 0));
            $criteria->add(new Criteria('conf_catid', XOOPS_CONF));
            $criteria->add(new Criteria('conf_name', 'language'));
            $configs =& $handler->getConfigs($criteria);

            if (count($configs) > 0) {
                $language = $configs[0]->get('conf_value', 'none');
            }
        }

        $languageManager = $this->createLanguageManager($language);
        $languageManager->setLanguage($language);
        $languageManager->prepare();

        $this->controller->getRoot()->setLanguageManager($languageManager);

        // If you use special page, load message catalog for it.
        if (isset($GLOBALS['xoopsOption']['pagetype'])) {
            $this->controller->getRoot()->getLanguageManager()->loadPageTypeMessageCatalog($GLOBALS['xoopsOption']['pagetype']);
        }
    }

    /**
     * Factory for the language manager. At first, this member function
     * delegates to get a instance of LanguageManager. If it can't get it, do
     * the following process:
     *
     * 1) Try creating a instance of 'Xcore_LanguageManager_' . ucfirst($language)
     * 2) If the class doesn't exist, try loading  'LanguageManager.class.php'
     *      in the specified language.
     * 3) Re-try creating the instance.
     *
     * If it can't create any instances, create a instance of
     * Xcore_LanguageManager as default.
     *
     * @access protected
     * @param string $language
     * @return Xcore_LanguageManager
     */
    private function createLanguageManager($language)
    {
        $languageManager = null;

        $this->controller->getCreateLanguageManagerDelegate()->call(new Ref($languageManager), $language);

        if ( !is_object($languageManager) ) {
            $className = 'Xcore_LanguageManager_'.ucfirst(strtolower($language));

            //
            // If the class exists, create a instance. Else, load the file, and
            // try creating a instance again.
            //
            if ( class_exists($className) ) {
                $languageManager = new $className();
            } else {
                $filePath = XOOPS_ROOT_PATH.'/language/'.$language.'/LanguageManager.class.php';
                if ( file_exists($filePath) ) {
                    require_once $filePath;
                }

                if ( class_exists($className) ) {
                    $languageManager = new $className();
                } else {
                    //
                    // Default
                    //
                    $languageManager = new Xcore_LanguageManager();
                }
            }
        }

        return $languageManager;
    }
}

