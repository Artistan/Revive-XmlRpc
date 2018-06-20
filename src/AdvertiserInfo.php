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
 *  The AdvertiserInfo class extends the base Info class and contains information about advertisers.
 *
 *  Advertiser is the
 */

class AdvertiserInfo extends Info
{
    /**
     * The advertiserID variable is the unique ID for the advertiser.
     *
     * @see https://documentation.revive-adserver.com/display/DOCS/Advertisers
     *
     * @var integer $advertiserId
     */
    var $advertiserId;

    /**
     * This field contains the ID of the agency account.
     *
     * @var integer $accountId
     */
    var $accountId;

    /**
     * The agencyID variable is the ID of the agency to which the advertiser is associated.
     *
     * @var integer $agencyId
     */
    var $agencyId;

    /**
     * The advertiserName variable is the name of the advertiser.
     *
     * @var string $advertiserName
     */
    var $advertiserName;

    /**
     * The contactName variable is the name of the contact.
     *
     * @var string $contactName
     */
    var $contactName;

    /**
     * The emailAddress variable is the email address for the contact.
     *
     * @var string $emailAddress
     */
    var $emailAddress;

    /**
     * This field provides any additional comments to be stored.
     *
     * @var string $comments
     */
    var $comments;

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
            'advertiserId' => 'integer',
            'accountId' => 'integer',
            'agencyId' => 'integer',
            'advertiserName' => 'string',
            'contactName' => 'string',
            'emailAddress' => 'string',
            'comments' => 'string',
        ];
    }
}
