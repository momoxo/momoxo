<?php


namespace XCore\Repository;

/**
 * XOOPS object handler class.
 * This class is an abstract class of handler classes that are responsible for providing
 * data access mechanisms to the data source of its corresponsing data objects
 * @package kernel
 * @abstract
 *
 * @author  Kazumi Ono <onokazu@xoops.org>
 * @copyright copyright &copy; 2000 The XOOPS Project
 */
use XCore\Database\Database;

class ObjectRepository
{

    /**
     * holds referenced to {@link Database} class object
     *
     * @var object
     * @see Database
     * @access protected
     */
    var $db;

    //
    /**
     * called from child classes only
     *
     * @param object $db reference to the {@link Database} object
     * @access protected
     */
    function __construct(&$db)
    {
        $this->db =& $db;
    }

    /**
     * creates a new object
     *
     * @abstract
     */
    function &create()
    {
    }

    /**
     * gets a value object
     *
     * @param int $int_id
     * @abstract
     */
    function &get($int_id)
    {
    }

    /**
     * insert/update object
     *
     * @param object $object
     * @abstract
     */
    function insert(&$object)
    {
    }

    /**
     * delete obejct from database
     *
     * @param object $object
     * @abstract
     */
    function delete(&$object)
    {
    }

}
