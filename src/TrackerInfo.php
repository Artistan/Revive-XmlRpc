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
 * The TrackerInfo class extends the base Info class and contains
 * information about tracker
 *
 */
class TrackerInfo extends Info
{
    // Required fields
    /**
     * The trackerId variable is the unique ID for the tracker.
     *
     * @var integer $trackerId
     */
    public $trackerId;

    /**
     * The clientId variable is the unique ID for the owner client.
     *
     * @var integer $clientId
     */
    public $clientId;

    /**
     * The trackerName variable is the name of the tracker.
     *
     * @var string $trackerName
     */
    public $trackerName;

    // Optional fields

    /**
     * This field provides a place for a description to be stored.
     *
     * @var string $description
     */
    public $description;

    /**
     * This field provides a optional connection status type if no status given, uses the tracker's default status.
     *     MAX_CONNECTION_STATUS_IGNORE:      1
     *     MAX_CONNECTION_STATUS_PENDING:     2
     *     MAX_CONNECTION_STATUS_ONHOLD:      3
     *     MAX_CONNECTION_STATUS_APPROVED:    4
     *     MAX_CONNECTION_STATUS_DISAPPROVED: 5
     *     MAX_CONNECTION_STATUS_DUPLICATE:   6
     *
     * @var string $status
     */
    public $status;

    /**
     * The type variable is the id of the type of tracker.
     *     SALE:   1
     *     LEAD:   2
     *     SIGNUP: 3
     *
     * @var integer $type
     */
    public $type;

    /**
     * This field is a boolean true on successful link, false on error.
     *
     * @var integer (0|1)
     */
    public $linkCampaigns;

    /**
     * The variableMethod variable is the method of the tracker.
     * 'default','js','dom','custom'
     *
     * @var string $variableMethod
     */
    public $variableMethod;

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
            'trackerId' => 'integer',
            'clientId' => 'integer',
            'trackerName' => 'string',
            'description' => 'string',
            'status' => 'integer',
            'type' => 'integer',
            'linkCampaigns' => 'boolean',
            'variableMethod' => 'string',
        ];
    }
}
