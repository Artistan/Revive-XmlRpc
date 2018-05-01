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

use PhpXmlRpc\Value;

/**
 * The XmlRpcUtils class contains various XmlRpc methods.
 *
 */
class XmlRpcUtils
{
    /**
     * This method converts the Info object into an XML_RPC_Value and deletes null fields.
     *
     * @param object &$oInfoObject
     * @return \PhpXmlRpc\Value
     */
    public static function getEntityWithNotNullFields(&$oInfoObject)
    {
        $aInfoData = $oInfoObject->toArray();
        $aReturnData = [];

        foreach ($aInfoData as $fieldName => $fieldValue) {
            if (! is_null($fieldValue)) {
                $aReturnData[$fieldName] = XmlRpcUtils::_setRPCTypeForField($oInfoObject->getFieldType($fieldName),
                    $fieldValue);
            }
        }

        return new Value($aReturnData, $GLOBALS['XML_RPC_Struct']);
    }

    /**
     * This method sets the RPC type for variables.
     *
     * @param string $type
     * @param mixed $variable
     * @return \PhpXmlRpc\Value or false
     */
    private static function _setRPCTypeForField($type, $variable)
    {
        switch ($type) {
            case 'string':
                return new Value($variable, $GLOBALS['XML_RPC_String']);

            case 'integer':
                return new Value($variable, $GLOBALS['XML_RPC_Int']);

            case 'float':
            case 'double':
                return new Value($variable, $GLOBALS['XML_RPC_Double']);

            case 'boolean':
                return new Value($variable, $GLOBALS['XML_RPC_Boolean']);

            case 'date':

                if (! is_object($variable) || ! is_a($variable, 'Date')) {
                    die('Value should be PEAR::Date type');
                }

                $value = $variable->format('%Y%m%d').'T00:00:00';

                return new Value($value, $GLOBALS['XML_RPC_DateTime']);

            case 'custom':
                return $variable;
        }
        die('Unsupported Xml Rpc type \''.$type.'\'');
    }
}
