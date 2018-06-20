<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

namespace Artistan\ReviveXmlRpc;

/**
 * The TargetingInfo class extends the base Info class and contains
 * information about targeting
 *
 */
class TargetingInfo extends Info
{
    /**
     * 99% will be "and" or "or", but that's not enforced
     *
     * @var string
     */
    public $logical;

    /**
     * This is the plugin-component identifier
     *
     * @var string
     */
    public $type;

    /**
     * String showing the operation to be applied (e.g.: '==', '!=', '>=',
     * 'ne')
     *
     * @var string
     */
    public $comparison;

    /**
     * The exact structure varies from component to component
     *
     * @var string
     */
    public $data;

    /**
     * This method returns an array of fields with their corresponding types.
     * @see \Artistan\ReviveXmlRpc\Info::getFieldsTypes()
     *
     * @access public
     *
     * @return array
     */
    function getFieldsTypes()
    {
        return [
            'logical' => 'string',
            'type' => 'string',
            'comparison' => 'string',
            'data' => 'string',
        ];
    }
}
