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

use PhpXmlRpc\Client;
use PhpXmlRpc\Encoder;
use PhpXmlRpc\Request;

/**
 * A library class to provide XML-RPC routines on
 * a web server to enable it to manipulate objects in OpenX using the web services API.
 *
 * @package    OpenX
 * @subpackage ExternalLibrary
 * @author     Chris Nutting <Chris.Nutting@openx.org>
 */
class OpenAdsV2ApiXmlRpc
{
    var $host;

    var $basepath;

    var $port;

    var $timeout;

    var $username;

    var $password;

    var $ssl;

    /**
     * The sessionId is set by the logon() method called during the constructor.
     *
     * @var string The remote session ID is used in all subsequent transactions.
     */
    var $sessionId;

    /**
     * Purely for my own use, this parameter lets me pass debug querystring parameters into
     * the remote call to trigger my Zend debugger on the server-side
     *
     * This will be removed before release
     *
     * @var string The querystring parameters required to trigger my remote debugger
     *             or empty for no remote debugging
     */
    var $debug = '';

    /**
     * PHP4 style constructor
     *
     * @param string $host The name of the host to which to connect.
     * @param string $basepath The base path to XML-RPC services.
     * @param string $username The username to authenticate to the web services API.
     * @param string $password The password for this user.
     * @param int $port The port number. Use 0 to use standard ports which
     *                          are port 80 for HTTP and port 443 for HTTPS.
     * @param bool $ssl Set to true to connect using an SSL connection.
     * @param int $timeout The timeout period to wait for a response.
     */
    function __construct($host, $basepath, $username, $password, $port = 0, $ssl = false, $timeout = 15)
    {
        $this->host = $host;
        $this->basepath = rtrim($basepath, '/');
        $this->port = $port;
        $this->timeout = $timeout;
        $this->username = $username;
        $this->password = $password;
        $this->ssl = $ssl;
        $this->_logon();
    }

    /**
     * A private method to return an XML_RPC_Client to the API service
     *
     * @return \PhpXmlRpc\Client
     */
    function &_getClient()
    {
        $oClient = new Client($this->basepath.'/'.$this->debug, $this->host, $this->port,
            $this->ssl ? 'https' : 'http');

        return $oClient;
    }

    /**
     * This private function sends a method call and $data to a specified service and automatically
     * adds the value of the sessionID.
     *
     * @param string $method The name of the remote method to call.
     * @param mixed $data The data to send to the web service.
     * @return mixed The response from the server or false in the event of failure.
     */
    function _sendWithSession($method, $data = [])
    {
        return $this->_send($method, array_merge([$this->sessionId], $data));
    }

    /**
     * This function sends a method call to a specified service.
     *
     * @param string $method The name of the remote method to call.
     * @param mixed $data The data to send to the web service.
     * @return mixed The response from the server or false in the event of failure.
     */
    function _send($method, $data)
    {
        $dataMessage = [];
        $encoder = new Encoder();
        $result = false;
        foreach ($data as $element) {
            if (is_object($element) && is_subclass_of($element, 'OA_Info')) {
                $dataMessage[] = XmlRpcUtils::getEntityWithNotNullFields($element);
            } else {
                $dataMessage[] = $encoder->encode($element);
            }
        }
        $message = new Request($method, $dataMessage);

        $client = &$this->_getClient();

        // Send the XML-RPC message to the server.
        $response = $client->send($message, $this->timeout);

        // Check for an error response.
        if ($response && $response->faultCode() == 0) {
            $result = $encoder->decode($response->value());
        } else {
            trigger_error('XML-RPC Error ('.$response->faultCode().'): '.$response->faultString().' in method '.$method.'()',
                E_USER_ERROR);
        }

        return $result;
    }

    /**
     * This method logs on to web services.
     *
     * @return boolean "Was the remote logon() call successful?"
     */
    function _logon()
    {
        $this->sessionId = $this->_send('ox.logon', [$this->username, $this->password]);

        return true;
    }

    /**
     * This method logs off from web wervices.
     *
     * @return boolean "Was the remote logoff() call successful?"
     */
    function logoff()
    {
        return (bool)$this->_sendWithSession('ox.logoff');
    }

    /**
     * This method returns statistics for an entity.
     *
     * @param string $methodName
     * @param int $entityId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function _callStatisticsMethod(
        $methodName,
        $entityId,
        $oStartDate = null,
        $oEndDate = null,
        $useManagerTimezone = false
    ) {
        $dataArray = [(int)$entityId];
        if (is_object($oStartDate)) {
            $dataArray[] = $oStartDate->format('%Y%m%dT%H:%M:%S');

            if (is_object($oEndDate)) {
                $dataArray[] = $oEndDate->format('%Y%m%dT%H:%M:%S');
            }
        }

        $dataArray[] = (bool)$useManagerTimezone;
        $statisticsData = $this->_sendWithSession($methodName, $dataArray);

        return $statisticsData;
    }

    /**
     * This method sends a call to the AgencyXmlRpcService and
     * passes the AgencyInfo with the session to add an agency.
     *
     * @param OA_Dll_AgencyInfo $oAgencyInfo
     * @return mixed result
     */
    function addAgency(&$oAgencyInfo)
    {
        return (int)$this->_sendWithSession('ox.addAgency', [&$oAgencyInfo]);
    }

    /**
     * This method sends a call to the AgencyXmlRpcService and
     * passes the AgencyInfo object with the session to modify an agency.
     *
     * @param OA_Dll_AgencyInfo $oAgencyInfo
     * @return mixed result
     */
    function modifyAgency(&$oAgencyInfo)
    {
        return (bool)$this->_sendWithSession('ox.modifyAgency', [&$oAgencyInfo]);
    }

    /**
     * This method  returns the AgencyInfo for a specified agency.
     *
     * @param int $agencyId
     * @return OA_Dll_AgencyInfo
     */
    function getAgency($agencyId)
    {
        $dataAgency = $this->_sendWithSession('ox.getAgency', [(int)$agencyId]);
        $oAgencyInfo = new OA_Dll_AgencyInfo();
        $oAgencyInfo->readDataFromArray($dataAgency);

        return $oAgencyInfo;
    }

    /**
     * This method returns AgencyInfo for all agencies.
     *
     * @return array  array OA_Dll_AgencyInfo objects
     */
    function getAgencyList()
    {
        $dataAgencyList = $this->_sendWithSession('ox.getAgencyList');
        $returnData = [];
        foreach ($dataAgencyList as $dataAgency) {
            $oAgencyInfo = new OA_Dll_AgencyInfo();
            $oAgencyInfo->readDataFromArray($dataAgency);
            $returnData[] = $oAgencyInfo;
        }

        return $returnData;
    }

    /**
     * This method deletes a specified agency.
     *
     * @param int $agencyId
     * @return mixed result
     */
    function deleteAgency($agencyId)
    {
        return (bool)$this->_sendWithSession('ox.deleteAgency', [(int)$agencyId]);
    }

    /**
     * This method returns the daily statistics for an agency for a specified time period.
     *
     * @param int $agencyId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function agencyDailyStatistics($agencyId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        $statisticsData = $this->_callStatisticsMethod('ox.agencyDailyStatistics', $agencyId, $oStartDate, $oEndDate,
            $useManagerTimezone);

        foreach ($statisticsData as $key => $data) {
            $statisticsData[$key]['day'] = \Carbon\Carbon::parse($data['day'])->format('Y-m-d');
        }

        return $statisticsData;
    }

    /**
     * This method returns the advertiser statistics for an agency for a specified time period.
     *
     * @param int $agencyId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function agencyAdvertiserStatistics($agencyId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.agencyAdvertiserStatistics', $agencyId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method returns the campaign statistics for an agency for a specified time period.
     *
     * @param int $agencyId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function agencyCampaignStatistics($agencyId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.agencyCampaignStatistics', $agencyId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method returns the banner statistics for an agency for a specified time period.
     *
     * @param int $agencyId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function agencyBannerStatistics($agencyId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.agencyBannerStatistics', $agencyId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method returns the publisher statistics for an agency for a specified time period.
     *
     * @param int $agencyId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function agencyPublisherStatistics($agencyId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.agencyPublisherStatistics', $agencyId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method returns the zone statistics for an agency for a specified time period.
     *
     * @param int $agencyId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function agencyZoneStatistics($agencyId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.agencyZoneStatistics', $agencyId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method adds an advertiser.
     *
     * @param OA_Dll_AdvertiserInfo $oAdvertiserInfo
     *
     * @return mixed result
     */
    function addAdvertiser(&$oAdvertiserInfo)
    {
        return (int)$this->_sendWithSession('ox.addAdvertiser', [&$oAdvertiserInfo]);
    }

    /**
     * This method modifies an advertiser.
     *
     * @param OA_Dll_AdvertiserInfo $oAdvertiserInfo
     *
     * @return mixed result
     */
    function modifyAdvertiser(&$oAdvertiserInfo)
    {
        return (bool)$this->_sendWithSession('ox.modifyAdvertiser', [&$oAdvertiserInfo]);
    }

    /**
     * This method returns AdvertiserInfo for a specified advertiser.
     *
     * @param int $advertiserId
     *
     * @return OA_Dll_AdvertiserInfo
     */
    function getAdvertiser($advertiserId)
    {
        $dataAdvertiser = $this->_sendWithSession('ox.getAdvertiser', [(int)$advertiserId]);
        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->readDataFromArray($dataAdvertiser);

        return $oAdvertiserInfo;
    }

    /**
     * This method returns a list of advertisers by Agency ID.
     *
     * @param int $agencyId
     *
     * @return array  array OA_Dll_AgencyInfo objects
     */
    function getAdvertiserListByAgencyId($agencyId)
    {
        $dataAdvertiserList = $this->_sendWithSession('ox.getAdvertiserListByAgencyId', [(int)$agencyId]);
        $returnData = [];
        foreach ($dataAdvertiserList as $dataAdvertiser) {
            $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
            $oAdvertiserInfo->readDataFromArray($dataAdvertiser);
            $returnData[] = $oAdvertiserInfo;
        }

        return $returnData;
    }

    /**
     * This method deletes an advertiser.
     *
     * @param int $advertiserId
     * @return mixed result
     */
    function deleteAdvertiser($advertiserId)
    {
        return (bool)$this->_sendWithSession('ox.deleteAdvertiser', [(int)$advertiserId]);
    }

    /**
     * This method returns daily statistics for an advertiser for a specified period.
     *
     * @param int $advertiserId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function advertiserDailyStatistics($advertiserId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        $statisticsData = $this->_callStatisticsMethod('ox.advertiserDailyStatistics', $advertiserId, $oStartDate,
            $oEndDate, $useManagerTimezone);

        foreach ($statisticsData as $key => $data) {
            $statisticsData[$key]['day'] = \Carbon\Carbon::parse($data['day'])->format('Y-m-d');
        }

        return $statisticsData;
    }

    /**
     * This method returns campaign statistics for an advertiser for a specified period.
     *
     * @param int $advertiserId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function advertiserCampaignStatistics(
        $advertiserId,
        $oStartDate = null,
        $oEndDate = null,
        $useManagerTimezone = false
    ) {
        return $this->_callStatisticsMethod('ox.advertiserCampaignStatistics', $advertiserId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method returns banner statistics for an advertiser for a specified period.
     *
     * @param int $advertiserId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function advertiserBannerStatistics(
        $advertiserId,
        $oStartDate = null,
        $oEndDate = null,
        $useManagerTimezone = false
    ) {
        return $this->_callStatisticsMethod('ox.advertiserBannerStatistics', $advertiserId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method returns publisher statistics for an advertiser for a specified period.
     *
     * @param int $advertiserId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function advertiserPublisherStatistics(
        $advertiserId,
        $oStartDate = null,
        $oEndDate = null,
        $useManagerTimezone = false
    ) {
        return $this->_callStatisticsMethod('ox.advertiserPublisherStatistics', $advertiserId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method returns zone statistics for an advertiser for a specified period.
     *
     * @param int $advertiserId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function advertiserZoneStatistics($advertiserId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.advertiserZoneStatistics', $advertiserId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method adds a campaign to the campaign object.
     *
     * @param OA_Dll_CampaignInfo $oCampaignInfo
     *
     * @return mixed result
     */
    function addCampaign(&$oCampaignInfo)
    {
        return (int)$this->_sendWithSession('ox.addCampaign', [&$oCampaignInfo]);
    }

    /**
     * This method modifies a campaign.
     *
     * @param OA_Dll_CampaignInfo $oCampaignInfo
     *
     * @return mixed result
     */
    function modifyCampaign(&$oCampaignInfo)
    {
        return (bool)$this->_sendWithSession('ox.modifyCampaign', [&$oCampaignInfo]);
    }

    /**
     * This method returns CampaignInfo for a specified campaign.
     *
     * @param int $campaignId
     *
     * @return OA_Dll_CampaignInfo
     */
    function getCampaign($campaignId)
    {
        $dataCampaign = $this->_sendWithSession('ox.getCampaign', [(int)$campaignId]);
        $oCampaignInfo = new OA_Dll_CampaignInfo();
        $oCampaignInfo->readDataFromArray($dataCampaign);

        return $oCampaignInfo;
    }

    /**
     * This method returns a list of campaigns for an advertiser.
     *
     * @param int $advertiserId
     *
     * @return array  array OA_Dll_CampaignInfo objects
     */
    function getCampaignListByAdvertiserId($advertiserId)
    {
        $dataCampaignList = $this->_sendWithSession('ox.getCampaignListByAdvertiserId', [(int)$advertiserId]);
        $returnData = [];
        foreach ($dataCampaignList as $dataCampaign) {
            $oCampaignInfo = new OA_Dll_CampaignInfo();
            $oCampaignInfo->readDataFromArray($dataCampaign);
            $returnData[] = $oCampaignInfo;
        }

        return $returnData;
    }

    /**
     * This method deletes a campaign from the campaign object.
     *
     * @param int $campaignId
     * @return mixed result
     */
    function deleteCampaign($campaignId)
    {
        return (bool)$this->_sendWithSession('ox.deleteCampaign', [(int)$campaignId]);
    }

    /**
     * This method returns daily statistics for a campaign for a specified period.
     *
     * @param int $campaignId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function campaignDailyStatistics($campaignId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        $statisticsData = $this->_callStatisticsMethod('ox.campaignDailyStatistics', $campaignId, $oStartDate,
            $oEndDate, $useManagerTimezone);

        foreach ($statisticsData as $key => $data) {
            $statisticsData[$key]['day'] = \Carbon\Carbon::parse($data['day'])->format('Y-m-d');
        }

        return $statisticsData;
    }

    /**
     * This method returns banner statistics for a campaign for a specified period.
     *
     * @param int $campaignId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function campaignBannerStatistics($campaignId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.campaignBannerStatistics', $campaignId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method returns publisher statistics for a campaign for a specified period.
     *
     * @param int $campaignId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function campaignPublisherStatistics($campaignId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.campaignPublisherStatistics', $campaignId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method returns zone statistics for a campaign for a specified period.
     *
     * @param int $campaignId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function campaignZoneStatistics($campaignId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.campaignZoneStatistics', $campaignId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method adds a banner to the banner object.
     *
     * @param OA_Dll_BannerInfo $oBannerInfo
     *
     * @return mixed result
     */
    function addBanner(&$oBannerInfo)
    {
        return (int)$this->_sendWithSession('ox.addBanner', [&$oBannerInfo]);
    }

    /**
     * This method modifies a banner.
     *
     * @param OA_Dll_BannerInfo $oBannerInfo
     *
     * @return mixed result
     */
    function modifyBanner(&$oBannerInfo)
    {
        return (bool)$this->_sendWithSession('ox.modifyBanner', [&$oBannerInfo]);
    }

    /**
     * This method returns BannerInfo for a specified banner.
     *
     * @param int $bannerId
     *
     * @return OA_Dll_BannerInfo
     */
    function getBanner($bannerId)
    {
        $dataBanner = $this->_sendWithSession('ox.getBanner', [(int)$bannerId]);
        $oBannerInfo = new OA_Dll_BannerInfo();
        $oBannerInfo->readDataFromArray($dataBanner);

        return $oBannerInfo;
    }

    /**
     * This method returns TargetingInfo for a specified banner.
     *
     * @param int $bannerId
     *
     * @return array
     */
    function getBannerTargeting($bannerId)
    {
        $dataBannerTargetingList = $this->_sendWithSession('ox.getBannerTargeting', [(int)$bannerId]);
        $returnData = [];
        foreach ($dataBannerTargetingList as $dataBannerTargeting) {
            $oBannerTargetingInfo = new OA_Dll_TargetingInfo();
            $oBannerTargetingInfo->readDataFromArray($dataBannerTargeting);
            $returnData[] = $oBannerTargetingInfo;
        }

        return $returnData;
    }

    /**
     * This method takes an array of targeting info objects and a banner id
     * and sets the targeting for the banner to the values passed in
     *
     * @param integer $bannerId
     * @param array $aTargeting
     *
     * @return bool
     */
    function setBannerTargeting($bannerId, $aTargeting)
    {
        $aTargetingInfoObjects = [];
        foreach ($aTargeting as $aTargetingArray) {
            $oTargetingInfo = new OA_Dll_TargetingInfo();
            $oTargetingInfo->readDataFromArray($aTargetingArray);
            $aTargetingInfoObjects[] = $oTargetingInfo;
        }

        return (bool)$this->_sendWithSession('ox.setBannerTargeting', [(int)$bannerId, $aTargetingInfoObjects]);
    }

    /**
     * This method returns a list of banners for a specified campaign.
     *
     * @param int $campaignId
     *
     * @return array  array OA_Dll_CampaignInfo objects
     */
    function getBannerListByCampaignId($campaignId)
    {
        $dataBannerList = $this->_sendWithSession('ox.getBannerListByCampaignId', [(int)$campaignId]);
        $returnData = [];
        foreach ($dataBannerList as $dataBanner) {
            $oBannerInfo = new OA_Dll_BannerInfo();
            $oBannerInfo->readDataFromArray($dataBanner);
            $returnData[] = $oBannerInfo;
        }

        return $returnData;
    }

    /**
     * This method deletes a banner from the banner object.
     *
     * @param int $bannerId
     * @return mixed result
     */
    function deleteBanner($bannerId)
    {
        return (bool)$this->_sendWithSession('ox.deleteBanner', [(int)$bannerId]);
    }

    /**
     * This method returns daily statistics for a banner for a specified period.
     *
     * @param int $bannerId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function bannerDailyStatistics($bannerId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        $statisticsData = $this->_callStatisticsMethod('ox.bannerDailyStatistics', $bannerId, $oStartDate, $oEndDate,
            $useManagerTimezone);

        foreach ($statisticsData as $key => $data) {
            $statisticsData[$key]['day'] = \Carbon\Carbon::parse($data['day'])->format('Y-m-d');
        }

        return $statisticsData;
    }

    /**
     * This method returns publisher statistics for a banner for a specified period.
     *
     * @param int $bannerId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function bannerPublisherStatistics($bannerId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.bannerPublisherStatistics', $bannerId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method returns zone statistics for a banner for a specified period.
     *
     * @param int $bannerId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function bannerZoneStatistics($bannerId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.bannerZoneStatistics', $bannerId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method adds a publisher to the publisher object.
     *
     * @param OA_Dll_PublisherInfo $oPublisherInfo
     * @return mixed result
     */
    function addPublisher(&$oPublisherInfo)
    {
        return (int)$this->_sendWithSession('ox.addPublisher', [&$oPublisherInfo]);
    }

    /**
     * This method modifies a publisher.
     *
     * @param OA_Dll_PublisherInfo $oPublisherInfo
     * @return mixed result
     */
    function modifyPublisher(&$oPublisherInfo)
    {
        return (bool)$this->_sendWithSession('ox.modifyPublisher', [&$oPublisherInfo]);
    }

    /**
     * This method returns PublisherInfo for a specified publisher.
     *
     * @param int $publisherId
     * @return OA_Dll_PublisherInfo
     */
    function getPublisher($publisherId)
    {
        $dataPublisher = $this->_sendWithSession('ox.getPublisher', [(int)$publisherId]);
        $oPublisherInfo = new OA_Dll_PublisherInfo();
        $oPublisherInfo->readDataFromArray($dataPublisher);

        return $oPublisherInfo;
    }

    /**
     * This method returns a list of publishers for a specified agency.
     *
     * @param int $agencyId
     * @return array  array OA_Dll_PublisherInfo objects
     */
    function getPublisherListByAgencyId($agencyId)
    {
        $dataPublisherList = $this->_sendWithSession('ox.getPublisherListByAgencyId', [(int)$agencyId]);
        $returnData = [];
        foreach ($dataPublisherList as $dataPublisher) {
            $oPublisherInfo = new OA_Dll_PublisherInfo();
            $oPublisherInfo->readDataFromArray($dataPublisher);
            $returnData[] = $oPublisherInfo;
        }

        return $returnData;
    }

    /**
     * This method deletes a publisher from the publisher object.
     *
     * @param int $publisherId
     * @return mixed result
     */
    function deletePublisher($publisherId)
    {
        return (bool)$this->_sendWithSession('ox.deletePublisher', [(int)$publisherId]);
    }

    /**
     * This method returns daily statistics for a publisher for a specified period.
     *
     * @param int $publisherId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function publisherDailyStatistics($publisherId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        $statisticsData = $this->_callStatisticsMethod('ox.publisherDailyStatistics', $publisherId, $oStartDate,
            $oEndDate, $useManagerTimezone);

        foreach ($statisticsData as $key => $data) {
            $statisticsData[$key]['day'] = \Carbon\Carbon::parse($data['day'])->format('Y-m-d');
        }

        return $statisticsData;
    }

    /**
     * This method returns zone statistics for a publisher for a specified period.
     *
     * @param int $publisherId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function publisherZoneStatistics($publisherId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.publisherZoneStatistics', $publisherId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method returns advertiser statistics for a specified period.
     *
     * @param int $publisherId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function publisherAdvertiserStatistics(
        $publisherId,
        $oStartDate = null,
        $oEndDate = null,
        $useManagerTimezone = false
    ) {
        return $this->_callStatisticsMethod('ox.publisherAdvertiserStatistics', $publisherId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method returns campaign statistics for a publisher for a specified period.
     *
     * @param int $publisherId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function publisherCampaignStatistics(
        $publisherId,
        $oStartDate = null,
        $oEndDate = null,
        $useManagerTimezone = false
    ) {
        return $this->_callStatisticsMethod('ox.publisherCampaignStatistics', $publisherId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method returns banner statistics for a publisher for a specified period.
     *
     * @param int $publisherId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function publisherBannerStatistics($publisherId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.publisherBannerStatistics', $publisherId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method adds a user to the user object.
     *
     * @param OA_Dll_UserInfo $oUserInfo
     * @return mixed result
     */
    function addUser(&$oUserInfo)
    {
        return (int)$this->_sendWithSession('ox.addUser', [&$oUserInfo]);
    }

    /**
     * This method modifies a user.
     *
     * @param OA_Dll_UserInfo $oUserInfo
     * @return mixed result
     */
    function modifyUser(&$oUserInfo)
    {
        return (bool)$this->_sendWithSession('ox.modifyUser', [&$oUserInfo]);
    }

    /**
     * This method returns UserInfo for a specified user.
     *
     * @param int $userId
     * @return OA_Dll_UserInfo
     */
    function getUser($userId)
    {
        $dataUser = $this->_sendWithSession('ox.getUser', [(int)$userId]);
        $oUserInfo = new OA_Dll_UserInfo();
        $oUserInfo->readDataFromArray($dataUser);

        return $oUserInfo;
    }

    /**
     * This method returns a list of users by Account ID.
     *
     * @param int $accountId
     *
     * @return array  array OA_Dll_UserInfo objects
     */
    function getUserListByAccountId($accountId)
    {
        $dataUserList = $this->_sendWithSession('ox.getUserListByAccountId', [(int)$accountId]);
        $returnData = [];
        foreach ($dataUserList as $dataUser) {
            $oUserInfo = new OA_Dll_UserInfo();
            $oUserInfo->readDataFromArray($dataUser);
            $returnData[] = $oUserInfo;
        }

        return $returnData;
    }

    /**
     * This method updates users SSO User Id
     *
     * @param int $oldSsoUserId
     * @param int $newSsoUserId
     * @return bool
     */
    function updateSsoUserId($oldSsoUserId, $newSsoUserId)
    {
        return (bool)$this->_sendWithSession('ox.updateSsoUserId', [(int)$oldSsoUserId, (int)$newSsoUserId]);
    }

    /**
     * This method updates users email by his SSO User Id
     *
     * @param int $ssoUserId
     * @param string $email
     * @return bool
     */
    function updateUserEmailBySsoId($ssoUserId, $email)
    {
        return (bool)$this->_sendWithSession('ox.updateUserEmailBySsoId', [(int)$ssoUserId, $email]);
    }

    /**
     * This method deletes a user from the user object.
     *
     * @param int $userId
     * @return mixed result
     */
    function deleteUser($userId)
    {
        return (bool)$this->_sendWithSession('ox.deleteUser', [(int)$userId]);
    }

    /**
     * This method adds a zone to the zone object.
     *
     * @param OA_Dll_ZoneInfo $oZoneInfo
     * @return mixed result
     */
    function addZone(&$oZoneInfo)
    {
        return (int)$this->_sendWithSession('ox.addZone', [&$oZoneInfo]);
    }

    /**
     * This method modifies a zone.
     *
     * @param OA_Dll_ZoneInfo $oZoneInfo
     * @return mixed result
     */
    function modifyZone(&$oZoneInfo)
    {
        return (bool)$this->_sendWithSession('ox.modifyZone', [&$oZoneInfo]);
    }

    /**
     * This method returns ZoneInfo for a specified zone.
     *
     * @param int $zoneId
     * @return OA_Dll_ZoneInfo
     */
    function getZone($zoneId)
    {
        $dataZone = $this->_sendWithSession('ox.getZone', [(int)$zoneId]);
        $oZoneInfo = new OA_Dll_ZoneInfo();
        $oZoneInfo->readDataFromArray($dataZone);

        return $oZoneInfo;
    }

    /**
     * This method returns a list of zones for a specified publisher.
     *
     * @param int $publisherId
     * @return array  array OA_Dll_ZoneInfo objects
     */
    function getZoneListByPublisherId($publisherId)
    {
        $dataZoneList = $this->_sendWithSession('ox.getZoneListByPublisherId', [(int)$publisherId]);
        $returnData = [];
        foreach ($dataZoneList as $dataZone) {
            $oZoneInfo = new OA_Dll_ZoneInfo();
            $oZoneInfo->readDataFromArray($dataZone);
            $returnData[] = $oZoneInfo;
        }

        return $returnData;
    }

    /**
     * This method deletes a zone from the zone object.
     *
     * @param int $zoneId
     * @return mixed result
     */
    function deleteZone($zoneId)
    {
        return (bool)$this->_sendWithSession('ox.deleteZone', [(int)$zoneId]);
    }

    /**
     * This method returns daily statistics for a zone for a specified period.
     *
     * @param int $zoneId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function zoneDailyStatistics($zoneId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        $statisticsData = $this->_callStatisticsMethod('ox.zoneDailyStatistics', $zoneId, $oStartDate, $oEndDate,
            $useManagerTimezone);

        foreach ($statisticsData as $key => $data) {
            $statisticsData[$key]['day'] = \Carbon\Carbon::parse($data['day'])->format('Y-m-d');
        }

        return $statisticsData;
    }

    /**
     * This method returns advertiser statistics for a zone for a specified period.
     *
     * @param int $zoneId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function zoneAdvertiserStatistics($zoneId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.xzoneAdvertiserStatistics', $zoneId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method returns campaign statistics for a zone for a specified period.
     *
     * @param int $zoneId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function zoneCampaignStatistics($zoneId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.zoneCampaignStatistics', $zoneId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    /**
     * This method returns publisher statistics for a zone for a specified period.
     *
     * @param int $zoneId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @param boolean $useManagerTimezone
     * @return array  result data
     */
    function zoneBannerStatistics($zoneId, $oStartDate = null, $oEndDate = null, $useManagerTimezone = false)
    {
        return $this->_callStatisticsMethod('ox.zoneBannerStatistics', $zoneId, $oStartDate, $oEndDate,
            $useManagerTimezone);
    }

    function linkBanner($zoneId, $bannerId)
    {
        return (bool)$this->_sendWithSession('ox.linkBanner', [(int)$zoneId, (int)$bannerId]);
    }

    function linkCampaign($zoneId, $campaignId)
    {
        return (bool)$this->_sendWithSession('ox.linkCampaign', [(int)$zoneId, (int)$campaignId]);
    }

    function unlinkBanner($zoneId, $bannerId)
    {
        return (bool)$this->_sendWithSession('ox.unlinkBanner', [(int)$zoneId, (int)$bannerId]);
    }

    function unlinkCampaign($zoneId, $campaignId)
    {
        return (bool)$this->_sendWithSession('ox.unlinkCampaign', [(int)$zoneId, (int)$campaignId]);
    }

    function generateTags($zoneId, $codeType, $aParams = null)
    {
        if (! isset($aParams)) {
            $aParams = [];
        }

        return $this->_sendWithSession('ox.generateTags', [(int)$zoneId, $codeType, $aParams]);
    }
}
