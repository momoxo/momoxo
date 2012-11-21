<?php

class Xcore_TextareaEditor extends XCube_ActionFilter
{
    /**
     * @public
     */
    function preBlockFilter()
    {
        $this->mRoot->mDelegateManager->add('Site.TextareaEditor.BBCode.Show','Xcore_TextareaEditor::renderBBCode',XCUBE_DELEGATE_PRIORITY_FINAL);
        $this->mRoot->mDelegateManager->add('Site.TextareaEditor.HTML.Show','Xcore_TextareaEditor::renderHTML',XCUBE_DELEGATE_PRIORITY_FINAL);
        $this->mRoot->mDelegateManager->add('Site.TextareaEditor.None.Show','Xcore_TextareaEditor::renderNone',XCUBE_DELEGATE_PRIORITY_FINAL);
    }

    /**
     *  @public
    */
    public static function renderBBCode(&$html, $params)
    {
        $form =new XoopsFormDhtmlTextArea($params['name'], $params['name'], $params['value'], $params['rows'], $params['cols']);
        $form->setId($params['id']);
        if ($params['class'] != null) {
            $form->setClass($params['class']);
        }
        
        $html = $form->render();
    }

    /**
     *  @public
    */
    public static function renderHtml(&$html, $params)
    {
        self::renderBBCode($html, $params);
    }

    /**
     *  @public
    */
    public static function renderNone(&$html, $params)
    {
        $form =new XoopsFormTextArea($params['name'], $params['name'], $params['value'], $params['rows'], $params['cols']);
        $form->setId($params['id']);
        if ($params['class'] != null) {
            $form->setClass($params['class']);
        }
        
        $html = $form->render();
    }
}
