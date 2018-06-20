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

/**
 * @package    OpenXDll
 *
 * The Info class is the base class for all info classes.
 */
abstract class Info
{
    /**
     * @param array $aEntityData
     */
    function __construct(array $aEntityData = [])
    {
        if (! empty($aEntityData)) {
            $this->readDataFromArray($aEntityData);
        }
    }

    /**
     * @param $aEntityData
     */
    function readDataFromArray($aEntityData)
    {
        $aFieldsTypes = $this->getFieldsTypes();
        foreach ($aFieldsTypes as $fieldName => $fieldType) {
            if (array_key_exists($fieldName, $aEntityData)) {
                if ($fieldType == 'date') {
                    $this->$fieldName = Carbon::parse($aEntityData[$fieldName]);
                } else {
                    $this->$fieldName = $aEntityData[$fieldName];
                }
            }
        }
    }

    /**
     * @return array
     */
    abstract function getFieldsTypes();

    /**
     * @param $fieldName
     * @return mixed
     */
    function getFieldType($fieldName)
    {
        $aFieldsTypes = $this->getFieldsTypes();
        if (! isset($aFieldsTypes) || ! is_array($aFieldsTypes)) {
            die('Please provide field types array for Info object creation');
        }

        if (! array_key_exists($fieldName, $aFieldsTypes)) {
            die('Unknown type for field \''.$fieldName.'\'');
        }

        return $aFieldsTypes[$fieldName];
    }

    /**
     * @return array
     */
    function toArray()
    {
        return (array)$this;
    }
}
