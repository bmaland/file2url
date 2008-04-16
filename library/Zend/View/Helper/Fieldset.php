<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to version 1.0 of the Zend Framework
 * license, that is bundled with this package in the file LICENSE.txt, and
 * is available through the world-wide-web at the following URL:
 * http://framework.zend.com/license/new-bsd. If you did not receive
 * a copy of the Zend Framework license and are unable to obtain it
 * through the world-wide-web, please send a note to license@zend.com
 * so we can mail you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @version    $Id: Fieldset.php 8118 2008-02-18 16:10:32Z matthew $
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/** Zend_View_Helper_FormElement */
require_once 'Zend/View/Helper/FormElement.php';

/**
 * Helper for rendering fieldsets
 *
 * @package    Zend_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_View_Helper_Fieldset extends Zend_View_Helper_FormElement
{
    /**
     * @var Zend_View_Instance
     */
    public $view;

    /**
     * Set view object
     * 
     * @param  Zend_View_Interface $view 
     * @return Zend_View_Helper_Form
     */
    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Render HTML form
     *
     * @param  string $name Form name
     * @param  string $content Form content
     * @param  array $attribs HTML form attributes
     * @return string
     */
    public function fieldset($name, $content, $attribs = null)
    {
        $info = $this->_getInfo($name, $content, $attribs);
        extract($info);

        $legend = '';
        if (isset($attribs['legend'])) {
            $legend = '<legend>' 
                    . $this->view->escape($attribs['legend']) 
                    . '</legend>' . PHP_EOL;
            unset($attribs['legend']);
        }
        $xhtml = '<fieldset'
               . ' id="'   . $this->view->escape($id)   . '"'
               . $this->_htmlAttribs($attribs)
               . '>'
               . $legend
               . $content
               . '</fieldset>';

        return $xhtml;
    }
}
