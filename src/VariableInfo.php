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
 * The VariableInfo class extends the base Info class and contains
 * information about variable
 *
 */
class VariableInfo extends Info
{
    const VARIABLE_DATATYPE_NUMERIC = 'numeric';
    const VARIABLE_DATATYPE_STRING = 'string';
    const VARIABLE_DATATYPE_DATE = 'date';
    const VARIABLE_PURPOSE_BASKET_VALUE = 'basket_value';
    const VARIABLE_PURPOSE_NUM_ITEMS = 'num_items';
    const VARIABLE_PURPOSE_POST_CODE = 'post_code';

    // Required fields
    /**
     * The variableId variable is the unique ID for the variable.
     *
     * @var integer $variableId
     */
    public $variableId;
    /**
     * The trackerId variable is the ID for the tracker.
     *
     * @var integer $trackerId
     */
    public $trackerId;
    /**
     * The variableName variable is the name of the variable.
     *
     * @var string $variableName
     */
    public $variableName;

    // Optional fields
    /**
     * This field provides a place for a description to be stored.
     *
     * @var string $description
     */
    public $description;
    /**
     * This field provides a optional data type
     *     MAX_CONNECTION_STATUS_IGNORE:      1
     *     MAX_CONNECTION_STATUS_PENDING:     2
     *     MAX_CONNECTION_STATUS_ONHOLD:      3
     *     MAX_CONNECTION_STATUS_APPROVED:    4
     *     MAX_CONNECTION_STATUS_DISAPPROVED: 5
     *     MAX_CONNECTION_STATUS_DUPLICATE:   6
     * @var string $dataType
     */
    public $dataType;
    /**
     * The purpose variable is the purpose of this defined variable.
     *     basket_value, num_items, post_code
     *
     * @var string $purpose
     */
    public $purpose;
    /**
     * This field is a boolean to reject if empty.
     *
     * @var integer $rejectIfEmpty (0|1)
     */
    public $rejectIfEmpty;
    /**
     * This field is a boolean defining uniqueness.
     *
     * @var integer $isUnique (0|1)
     */
    public $isUnique;
    /**
     * This field is a boolean if use unique window.
     *
     * @var integer $uniqueWindow (0|1)
     */
    public $uniqueWindow;
    /**
     * The variableCode variable is the code of the variable.
     *
     * how it is used...
     *         MAX_TrackVarJs('{$trackerJsCode}', '{$variable['name']}', '".addcslashes($variable['variablecode'], "'")."');";
     *
     * @var string $variableCode
     */
    public $variableCode;
    /**
     * This field is a boolean for hidden variable.
     *
     * @var integer $hidden (0|1)
     */
    public $hidden;
    /**
     * This field is an array for hidden websites.
     *
     * @var array $hiddenWebsites
     */
    public $hiddenWebsites;
    
    function getFieldsTypes()
    {
        return array(
            'variableId' => 'integer',
            'trackerId' => 'integer',
            'variableName' => 'string',
            'description' => 'string',
            'dataType' => 'string',
            'purpose' => 'string',
            'rejectIfEmpty' => 'boolean',
            'isUnique' => 'boolean',
            'uniqueWindow' => 'integer',
            'variableCode' => 'string',
            'hidden' => 'boolean',
            'hiddenWebsites' => 'array'
        );
    }
}
