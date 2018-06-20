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

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use PhpXmlRpc\Value;

/**
 * The XmlRpcUtils class contains various XmlRpc methods.
 *
 */
class XmlRpcUtils
{
    /**
     * This method converts the Info object into an Value and deletes null fields.
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
                $aReturnData[$fieldName] = XmlRpcUtils::getRPCTypeForField($oInfoObject->getFieldType($fieldName),
                    $fieldValue);
            }
        }

        return new Value($aReturnData, 'struct');
    }

    /**
     * This method sets the RPC type for variables.
     *
     * @param string $type
     * @param mixed $variable
     * @return \PhpXmlRpc\Value or false
     */
    public static function getRPCTypeForField($type, $variable)
    {
        switch ($type) {
            case 'integer':
                $type = 'int';
                return new Value($variable, $type);
            case 'string':
            case 'float':
            case 'double':
            case 'boolean':
                return new Value($variable, $type);
            case 'date':
                if (! is_object($variable) || ! method_exists($variable, 'format')) {
                    die('Value should be valid object which implements DateTimeInterface with format method');
                }
                /** @var \DateTimeInterface $variable */
                $value = $variable->format('Ymd\TH:i:S');

                return new Value($value, 'dateTime.iso8601');
            case 'custom':
                return $variable;
        }
        die('Unsupported Xml Rpc type \''.$type.'\'');
    }

    /**
     * @param mixed $date
     * @return \Carbon\Carbon|null
     */
    public static function dateObject($date)
    {
        if (! is_a($date, 'DateTimeInterface')) {
            if (is_object($date) && method_exists($date, 'format')) {
                Log::info('attempting to convert date object...');
                $date = Carbon::parse($date->format('Y-m-d H:i:s'));
            } else {
                if (is_string($date)) {
                    $date = Carbon::parse($date);
                } else {
                    $date = null;
                }
            }
        }

        return $date;
    }
}
