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
use PhpXmlRpc\Value;

/**
 * A library class to provide XML-RPC routines on
 * a web server to enable it to manipulate objects in OpenX using the web services API.
 *
 * @package    OpenX
 * @subpackage ExternalLibrary
 */
class OpenAdsV1ApiXmlRpc
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
     * A private method to return an Client to the API service
     *
     * @param string $service
     * @return \PhpXmlRpc\Client
     */
    function &_getClient($service)
    {
        $oClient = new Client($this->basepath.'/'.$service.$this->debug, $this->host, $this->port,
            $this->ssl ? 'https' : 'http');

        return $oClient;
    }

    /**
     * This private function sends a method call and $data to a specified service and automatically
     * adds the value of the sessionID.
     *
     * @param string $service The name of the remote service file.
     * @param string $method The name of the remote method to call.
     * @param mixed $data The data to send to the web service.
     * @return mixed The response from the server or false in the event of failure.
     */
    function _sendWithSession($service, $method, $data = [])
    {
        return $this->_send($service, $method, array_merge([$this->sessionId], $data));
    }

    /**
     * This function sends a method call to a specified service.
     *
     * @param string $service The name of the remote service file.
     * @param string $method The name of the remote method to call.
     * @param mixed $data The data to send to the web service.
     * @return mixed The response from the server or false in the event of failure.
     */
    function _send($service, $method, $data)
    {
        $result = false;
        $dataMessage = [];
        $encoder = new Encoder();
        foreach ($data as $element) {
            if (is_object($element) && is_subclass_of($element, 'Artistan\ReviveXmlRpc\Info')) {
                $dataMessage[] = XmlRpcUtils::getEntityWithNotNullFields($element);
            } else {
                if(is_a($element, 'DateTimeInterface')) {
                    /** @var \DateTimeInterface $element */
                    $value = $element->format('Ymd\TH:i:s');
                    $dataMessage[] = new Value($value, 'dateTime.iso8601');
                } else {
                    $dataMessage[] = $encoder->encode($element);
                }
            }
        }
        $message = new Request($method, $dataMessage);

        $client = &$this->_getClient($service);

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
        $this->sessionId = $this->_send('LogonXmlRpcService.php', 'logon', [$this->username, $this->password]);

        return true;
    }

    /**
     * This method logs off from web wervices.
     *
     * @return boolean "Was the remote logoff() call successful?"
     */
    function logoff()
    {
        return (bool)$this->_sendWithSession('LogonXmlRpcService.php', 'logoff');
    }

    /**
     * This method returns statistics for an entity.
     *
     * @param string $serviceFileName
     * @param string $methodName
     * @param int $entityId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function _callStatisticsMethod($serviceFileName, $methodName, $entityId, $oStartDate = null, $oEndDate = null)
    {
        $dataArray = [
            (int)$entityId,
            XmlRpcUtils::dateObject($oStartDate),
            XmlRpcUtils::dateObject($oEndDate)
        ];


        $statisticsData = $this->_sendWithSession($serviceFileName, $methodName, $dataArray);

        return $statisticsData;
    }

    /**
     * This method sends a call to the AgencyXmlRpcService and
     * passes the AgencyInfo with the session to add an agency.
     *
     * @param AgencyInfo $oAgencyInfo
     * @return mixed result
     */
    function addAgency(&$oAgencyInfo)
    {
        return (int)$this->_sendWithSession('AgencyXmlRpcService.php', 'addAgency', [&$oAgencyInfo]);
    }

    /**
     * This method sends a call to the AgencyXmlRpcService and
     * passes the AgencyInfo object with the session to modify an agency.
     *
     * @param AgencyInfo $oAgencyInfo
     * @return mixed result
     */
    function modifyAgency(&$oAgencyInfo)
    {
        return (bool)$this->_sendWithSession('AgencyXmlRpcService.php', 'modifyAgency', [&$oAgencyInfo]);
    }

    /**
     * This method  returns the AgencyInfo for a specified agency.
     *
     * @param int $agencyId
     * @return AgencyInfo
     */
    function getAgency($agencyId)
    {
        $dataAgency = $this->_sendWithSession('AgencyXmlRpcService.php', 'getAgency', [(int)$agencyId]);
        $oAgencyInfo = new AgencyInfo($dataAgency);

        return $oAgencyInfo;
    }

    /**
     * This method returns AgencyInfo for all agencies.
     *
     * @return array  array AgencyInfo objects
     */
    function getAgencyList()
    {
        $dataAgencyList = $this->_sendWithSession('AgencyXmlRpcService.php', 'getAgencyList');
        $returnData = [];
        foreach ($dataAgencyList as $dataAgency) {
            $oAgencyInfo = new AgencyInfo($dataAgency);
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
        return (bool)$this->_sendWithSession('AgencyXmlRpcService.php', 'deleteAgency', [(int)$agencyId]);
    }

    /**
     * @param $serviceFileName
     * @param $methodName
     * @param $agencyId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array
     */
    private function _dailyStatistics($serviceFileName, $methodName, $agencyId, $oStartDate = null, $oEndDate = null)
    {

        $statisticsData = $this->_callStatisticsMethod($serviceFileName, $methodName, $agencyId, $oStartDate,
            $oEndDate);

        foreach ($statisticsData as $key => $data) {
            $statisticsData[$key]['day'] = \Carbon\Carbon::parse($data['day'])->format('Y-m-d');
        }

        return $statisticsData;
    }

    /**
     * This method returns the daily statistics for an agency for a specified time period.
     *
     * @param int $agencyId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function agencyDailyStatistics($agencyId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_dailyStatistics('AgencyXmlRpcService.php', 'agencyDailyStatistics', $agencyId, $oStartDate,
            $oEndDate);
    }

    /**
     * This method returns the advertiser statistics for an agency for a specified time period.
     *
     * @param int $agencyId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function agencyAdvertiserStatistics($agencyId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AgencyXmlRpcService.php', 'agencyAdvertiserStatistics', $agencyId,
            $oStartDate, $oEndDate);
    }

    /**
     * This method returns the campaign statistics for an agency for a specified time period.
     *
     * @param int $agencyId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function agencyCampaignStatistics($agencyId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AgencyXmlRpcService.php', 'agencyCampaignStatistics', $agencyId,
            $oStartDate, $oEndDate);
    }

    /**
     * This method returns the banner statistics for an agency for a specified time period.
     *
     * @param int $agencyId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function agencyBannerStatistics($agencyId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AgencyXmlRpcService.php', 'agencyBannerStatistics', $agencyId, $oStartDate,
            $oEndDate);
    }

    /**
     * This method returns the publisher statistics for an agency for a specified time period.
     *
     * @param int $agencyId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function agencyPublisherStatistics($agencyId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AgencyXmlRpcService.php', 'agencyPublisherStatistics', $agencyId,
            $oStartDate, $oEndDate);
    }

    /**
     * This method returns the zone statistics for an agency for a specified time period.
     *
     * @param int $agencyId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function agencyZoneStatistics($agencyId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AgencyXmlRpcService.php', 'agencyZoneStatistics', $agencyId, $oStartDate,
            $oEndDate);
    }

    /**
     * This method adds an advertiser.
     *
     * @param AdvertiserInfo $oAdvertiserInfo
     *
     * @return  mixed result
     */
    function addAdvertiser(&$oAdvertiserInfo)
    {
        return (int)$this->_sendWithSession('AdvertiserXmlRpcService.php', 'addAdvertiser', [&$oAdvertiserInfo]);
    }

    /**
     * This method modifies an advertiser.
     *
     * @param AdvertiserInfo $oAdvertiserInfo
     *
     * @return  mixed result
     */
    function modifyAdvertiser(&$oAdvertiserInfo)
    {
        return (bool)$this->_sendWithSession('AdvertiserXmlRpcService.php', 'modifyAdvertiser', [&$oAdvertiserInfo]);
    }

    /**
     * This method returns AdvertiserInfo for a specified advertiser.
     *
     * @param int $advertiserId
     *
     * @return AdvertiserInfo
     */
    function getAdvertiser($advertiserId)
    {
        $dataAdvertiser = $this->_sendWithSession('AdvertiserXmlRpcService.php', 'getAdvertiser', [(int)$advertiserId]);
        $oAdvertiserInfo = new AdvertiserInfo($dataAdvertiser);

        return $oAdvertiserInfo;
    }

    /**
     * This method returns a list of advertisers by Agency ID.
     *
     * @param int $agencyId
     *
     * @return array  array AgencyInfo objects
     */
    function getAdvertiserListByAgencyId($agencyId)
    {
        $dataAdvertiserList = $this->_sendWithSession('AdvertiserXmlRpcService.php', 'getAdvertiserListByAgencyId',
            [(int)$agencyId]);
        $returnData = [];
        foreach ($dataAdvertiserList as $dataAdvertiser) {
            $oAdvertiserInfo = new AdvertiserInfo($dataAdvertiser);
            $returnData[] = $oAdvertiserInfo;
        }

        return $returnData;
    }

    /**
     * This method deletes an advertiser.
     *
     * @param int $advertiserId
     * @return  mixed result
     */
    function deleteAdvertiser($advertiserId)
    {
        return (bool)$this->_sendWithSession('AdvertiserXmlRpcService.php', 'deleteAdvertiser', [(int)$advertiserId]);
    }

    /**
     * This method returns daily statistics for an advertiser for a specified period.
     *
     * @param int $advertiserId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function advertiserDailyStatistics($advertiserId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_dailyStatistics('AdvertiserXmlRpcService.php', 'advertiserDailyStatistics', $advertiserId,
            $oStartDate, $oEndDate);
    }

    /**
     * This method returns campaign statistics for an advertiser for a specified period.
     *
     * @param int $advertiserId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function advertiserCampaignStatistics($advertiserId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AdvertiserXmlRpcService.php', 'advertiserCampaignStatistics',
            $advertiserId, $oStartDate, $oEndDate);
    }

    /**
     * This method returns banner statistics for an advertiser for a specified period.
     *
     * @param int $advertiserId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function advertiserBannerStatistics($advertiserId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AdvertiserXmlRpcService.php', 'advertiserBannerStatistics', $advertiserId,
            $oStartDate, $oEndDate);
    }

    /**
     * This method returns publisher statistics for an advertiser for a specified period.
     *
     * @param int $advertiserId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function advertiserPublisherStatistics($advertiserId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AdvertiserXmlRpcService.php', 'advertiserPublisherStatistics',
            $advertiserId, $oStartDate, $oEndDate);
    }

    /**
     * This method returns zone statistics for an advertiser for a specified period.
     *
     * @param int $advertiserId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function advertiserZoneStatistics($advertiserId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AdvertiserXmlRpcService.php', 'advertiserZoneStatistics', $advertiserId,
            $oStartDate, $oEndDate);
    }

    /**
     * This method adds a campaign to the campaign object.
     *
     * @param CampaignInfo $oCampaignInfo
     *
     * @return  mixed result
     */
    function addCampaign(&$oCampaignInfo)
    {
        return (int)$this->_sendWithSession('CampaignXmlRpcService.php', 'addCampaign', [&$oCampaignInfo]);
    }

    /**
     * This method modifies a campaign.
     *
     * @param CampaignInfo $oCampaignInfo
     *
     * @return  mixed result
     */
    function modifyCampaign(&$oCampaignInfo)
    {
        return (bool)$this->_sendWithSession('CampaignXmlRpcService.php', 'modifyCampaign', [&$oCampaignInfo]);
    }

    /**
     * This method returns CampaignInfo for a specified campaign.
     *
     * @param int $campaignId
     *
     * @return CampaignInfo
     */
    function getCampaign($campaignId)
    {
        $dataCampaign = $this->_sendWithSession('CampaignXmlRpcService.php', 'getCampaign', [(int)$campaignId]);
        $oCampaignInfo = new CampaignInfo($dataCampaign);

        return $oCampaignInfo;
    }

    /**
     * This method returns a list of campaigns for an advertiser.
     *
     * @param int $advertiserId
     *
     * @return array  array CampaignInfo objects
     */
    function getCampaignListByAdvertiserId($advertiserId)
    {
        $dataCampaignList = $this->_sendWithSession('CampaignXmlRpcService.php', 'getCampaignListByAdvertiserId',
            [(int)$advertiserId]);
        $returnData = [];
        foreach ($dataCampaignList as $dataCampaign) {
            $oCampaignInfo = new CampaignInfo($dataCampaign);
            $returnData[] = $oCampaignInfo;
        }

        return $returnData;
    }

    /**
     * This method deletes a campaign from the campaign object.
     *
     * @param int $campaignId
     * @return  mixed result
     */
    function deleteCampaign($campaignId)
    {
        return (bool)$this->_sendWithSession('CampaignXmlRpcService.php', 'deleteCampaign', [(int)$campaignId]);
    }

    /**
     * This method returns daily statistics for a campaign for a specified period.
     *
     * @param int $campaignId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function campaignDailyStatistics($campaignId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_dailyStatistics('CampaignXmlRpcService.php', 'campaignDailyStatistics', $campaignId, $oStartDate,
            $oEndDate);
    }

    /**
     * This method returns banner statistics for a campaign for a specified period.
     *
     * @param int $campaignId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function campaignBannerStatistics($campaignId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('CampaignXmlRpcService.php', 'campaignBannerStatistics', $campaignId,
            $oStartDate, $oEndDate);
    }

    /**
     * This method returns publisher statistics for a campaign for a specified period.
     *
     * @param int $campaignId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function campaignPublisherStatistics($campaignId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('CampaignXmlRpcService.php', 'campaignPublisherStatistics', $campaignId,
            $oStartDate, $oEndDate);
    }

    /**
     * This method returns zone statistics for a campaign for a specified period.
     *
     * @param int $campaignId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function campaignZoneStatistics($campaignId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('CampaignXmlRpcService.php', 'campaignZoneStatistics', $campaignId,
            $oStartDate, $oEndDate);
    }

    /**
     * This method adds a banner to the banner object.
     *
     * @param BannerInfo $oBannerInfo
     *
     * @return  mixed result
     */
    function addBanner(&$oBannerInfo)
    {
        return (int)$this->_sendWithSession('BannerXmlRpcService.php', 'addBanner', [&$oBannerInfo]);
    }

    /**
     * This method modifies a banner.
     *
     * @param BannerInfo $oBannerInfo
     *
     * @return  mixed result
     */
    function modifyBanner(&$oBannerInfo)
    {
        return (bool)$this->_sendWithSession('BannerXmlRpcService.php', 'modifyBanner', [&$oBannerInfo]);
    }

    /**
     * This method returns BannerInfo for a specified banner.
     *
     * @param int $bannerId
     *
     * @return BannerInfo
     */
    function getBanner($bannerId)
    {
        $dataBanner = $this->_sendWithSession('BannerXmlRpcService.php', 'getBanner', [(int)$bannerId]);
        $oBannerInfo = new BannerInfo($dataBanner);

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
        $dataBannerTargetingList = $this->_sendWithSession('BannerXmlRpcService.php', 'getBannerTargeting',
            [(int)$bannerId]);
        $returnData = [];
        foreach ($dataBannerTargetingList as $dataBannerTargeting) {
            $oBannerTargetingInfo = new TargetingInfo($dataBannerTargeting);
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
            $oTargetingInfo = new TargetingInfo($aTargetingArray);
            $aTargetingInfoObjects[] = $oTargetingInfo;
        }

        return (bool)$this->_sendWithSession('BannerXmlRpcService.php', 'setBannerTargeting',
            [(int)$bannerId, $aTargetingInfoObjects]);
    }

    /**
     * This method returns a list of banners for a specified campaign.
     *
     * @param int $campaignId
     *
     * @return array  array CampaignInfo objects
     */
    function getBannerListByCampaignId($campaignId)
    {
        $dataBannerList = $this->_sendWithSession('BannerXmlRpcService.php', 'getBannerListByCampaignId',
            [(int)$campaignId]);
        $returnData = [];
        foreach ($dataBannerList as $dataBanner) {
            $oBannerInfo = new BannerInfo($dataBanner);
            $returnData[] = $oBannerInfo;
        }

        return $returnData;
    }

    /**
     * This method deletes a banner from the banner object.
     *
     * @param int $bannerId
     * @return  mixed result
     */
    function deleteBanner($bannerId)
    {
        return (bool)$this->_sendWithSession('BannerXmlRpcService.php', 'deleteBanner', [(int)$bannerId]);
    }

    /**
     * This method returns daily statistics for a banner for a specified period.
     *
     * @param int $bannerId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function bannerDailyStatistics($bannerId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_dailyStatistics('BannerXmlRpcService.php', 'bannerDailyStatistics', $bannerId, $oStartDate,
            $oEndDate);
    }

    /**
     * This method returns publisher statistics for a banner for a specified period.
     *
     * @param int $bannerId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function bannerPublisherStatistics($bannerId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('BannerXmlRpcService.php', 'bannerPublisherStatistics', $bannerId,
            $oStartDate, $oEndDate);
    }

    /**
     * This method returns zone statistics for a banner for a specified period.
     *
     * @param int $bannerId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function bannerZoneStatistics($bannerId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('BannerXmlRpcService.php', 'bannerZoneStatistics', $bannerId, $oStartDate,
            $oEndDate);
    }

    /**
     * This method adds a publisher to the publisher object.
     *
     * @param PublisherInfo $oPublisherInfo
     * @return  mixed result
     */
    function addPublisher(&$oPublisherInfo)
    {
        return (int)$this->_sendWithSession('PublisherXmlRpcService.php', 'addPublisher', [&$oPublisherInfo]);
    }

    /**
     * This method modifies a publisher.
     *
     * @param PublisherInfo $oPublisherInfo
     * @return  mixed result
     */
    function modifyPublisher(&$oPublisherInfo)
    {
        return (bool)$this->_sendWithSession('PublisherXmlRpcService.php', 'modifyPublisher', [&$oPublisherInfo]);
    }

    /**
     * This method returns PublisherInfo for a specified publisher.
     *
     * @param int $publisherId
     * @return PublisherInfo
     */
    function getPublisher($publisherId)
    {
        $dataPublisher = $this->_sendWithSession('PublisherXmlRpcService.php', 'getPublisher', [(int)$publisherId]);
        $oPublisherInfo = new PublisherInfo($dataPublisher);

        return $oPublisherInfo;
    }

    /**
     * This method returns a list of publishers for a specified agency.
     *
     * @param int $agencyId
     * @return array  array PublisherInfo objects
     */
    function getPublisherListByAgencyId($agencyId)
    {
        $dataPublisherList = $this->_sendWithSession('PublisherXmlRpcService.php', 'getPublisherListByAgencyId',
            [(int)$agencyId]);
        $returnData = [];
        foreach ($dataPublisherList as $dataPublisher) {
            $oPublisherInfo = new PublisherInfo($dataPublisher);
            $returnData[] = $oPublisherInfo;
        }

        return $returnData;
    }

    /**
     * This method deletes a publisher from the publisher object.
     *
     * @param int $publisherId
     * @return  mixed result
     */
    function deletePublisher($publisherId)
    {
        return (bool)$this->_sendWithSession('PublisherXmlRpcService.php', 'deletePublisher', [(int)$publisherId]);
    }

    /**
     * This method returns daily statistics for a publisher for a specified period.
     *
     * @param int $publisherId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function publisherDailyStatistics($publisherId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_dailyStatistics('PublisherXmlRpcService.php', 'publisherDailyStatistics', $publisherId,
            $oStartDate, $oEndDate);
    }

    /**
     * This method returns zone statistics for a publisher for a specified period.
     *
     * @param int $publisherId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function publisherZoneStatistics($publisherId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('PublisherXmlRpcService.php', 'publisherZoneStatistics', $publisherId,
            $oStartDate, $oEndDate);
    }

    /**
     * This method returns advertiser statistics for a specified period.
     *
     * @param int $publisherId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function publisherAdvertiserStatistics($publisherId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('PublisherXmlRpcService.php', 'publisherAdvertiserStatistics', $publisherId,
            $oStartDate, $oEndDate);
    }

    /**
     * This method returns campaign statistics for a publisher for a specified period.
     *
     * @param int $publisherId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function publisherCampaignStatistics($publisherId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('PublisherXmlRpcService.php', 'publisherCampaignStatistics', $publisherId,
            $oStartDate, $oEndDate);
    }

    /**
     * This method returns banner statistics for a publisher for a specified period.
     *
     * @param int $publisherId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function publisherBannerStatistics($publisherId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('PublisherXmlRpcService.php', 'publisherBannerStatistics', $publisherId,
            $oStartDate, $oEndDate);
    }

    /**
     * This method adds a user to the user object.
     *
     * @param UserInfo $oUserInfo
     * @return  mixed result
     */
    function addUser(&$oUserInfo)
    {
        return (int)$this->_sendWithSession('UserXmlRpcService.php', 'addUser', [&$oUserInfo]);
    }

    /**
     * This method modifies a user.
     *
     * @param UserInfo $oUserInfo
     * @return  mixed result
     */
    function modifyUser(&$oUserInfo)
    {
        return (bool)$this->_sendWithSession('UserXmlRpcService.php', 'modifyUser', [&$oUserInfo]);
    }

    /**
     * This method returns UserInfo for a specified user.
     *
     * @param int $userId
     * @return UserInfo
     */
    function getUser($userId)
    {
        $dataUser = $this->_sendWithSession('UserXmlRpcService.php', 'getUser', [(int)$userId]);
        $oUserInfo = new UserInfo($dataUser);

        return $oUserInfo;
    }

    /**
     * This method returns a list of users by Account ID.
     *
     * @param int $accountId
     *
     * @return array  array UserInfo objects
     */
    function getUserListByAccountId($accountId)
    {
        $dataUserList = $this->_sendWithSession('UserXmlRpcService.php', 'getUserListByAccountId', [(int)$accountId]);
        $returnData = [];
        foreach ($dataUserList as $dataUser) {
            $oUserInfo = new UserInfo($dataUser);
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
        return (bool)$this->_sendWithSession('UserXmlRpcService.php', 'updateSsoUserId',
            [(int)$oldSsoUserId, (int)$newSsoUserId]);
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
        return (bool)$this->_sendWithSession('UserXmlRpcService.php', 'updateUserEmailBySsoId',
            [(int)$ssoUserId, $email]);
    }

    /**
     * This method deletes a user from the user object.
     *
     * @param int $userId
     * @return  mixed result
     */
    function deleteUser($userId)
    {
        return (bool)$this->_sendWithSession('UserXmlRpcService.php', 'deleteUser', [(int)$userId]);
    }

    /**
     * This method adds a zone to the zone object.
     *
     * @param ZoneInfo $oZoneInfo
     * @return  mixed result
     */
    function addZone(&$oZoneInfo)
    {
        return (int)$this->_sendWithSession('ZoneXmlRpcService.php', 'addZone', [&$oZoneInfo]);
    }

    /**
     * This method modifies a zone.
     *
     * @param ZoneInfo $oZoneInfo
     * @return  mixed result
     */
    function modifyZone(&$oZoneInfo)
    {
        return (bool)$this->_sendWithSession('ZoneXmlRpcService.php', 'modifyZone', [&$oZoneInfo]);
    }

    /**
     * This method returns ZoneInfo for a specified zone.
     *
     * @param int $zoneId
     * @return ZoneInfo
     */
    function getZone($zoneId)
    {
        $dataZone = $this->_sendWithSession('ZoneXmlRpcService.php', 'getZone', [(int)$zoneId]);
        $oZoneInfo = new ZoneInfo($dataZone);

        return $oZoneInfo;
    }

    /**
     * This method returns a list of zones for a specified publisher.
     *
     * @param int $publisherId
     * @return array  array ZoneInfo objects
     */
    function getZoneListByPublisherId($publisherId)
    {
        $dataZoneList = $this->_sendWithSession('ZoneXmlRpcService.php', 'getZoneListByPublisherId',
            [(int)$publisherId]);
        $returnData = [];
        foreach ($dataZoneList as $dataZone) {
            $oZoneInfo = new ZoneInfo($dataZone);
            $returnData[] = $oZoneInfo;
        }

        return $returnData;
    }

    /**
     * This method deletes a zone from the zone object.
     *
     * @param int $zoneId
     * @return  mixed result
     */
    function deleteZone($zoneId)
    {
        return (bool)$this->_sendWithSession('ZoneXmlRpcService.php', 'deleteZone', [(int)$zoneId]);
    }

    /**
     * This method returns daily statistics for a zone for a specified period.
     *
     * @param int $zoneId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function zoneDailyStatistics($zoneId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_dailyStatistics('ZoneXmlRpcService.php', 'zoneDailyStatistics', $zoneId, $oStartDate, $oEndDate);
    }

    /**
     * This method returns advertiser statistics for a zone for a specified period.
     *
     * @param int $zoneId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function zoneAdvertiserStatistics($zoneId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('ZoneXmlRpcService.php', 'zoneAdvertiserStatistics', $zoneId, $oStartDate,
            $oEndDate);
    }

    /**
     * This method returns campaign statistics for a zone for a specified period.
     *
     * @param int $zoneId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function zoneCampaignStatistics($zoneId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('ZoneXmlRpcService.php', 'zoneCampaignStatistics', $zoneId, $oStartDate,
            $oEndDate);
    }

    /**
     * This method returns publisher statistics for a zone for a specified period.
     *
     * @param int $zoneId
     * @param \Carbon\Carbon $oStartDate
     * @param \Carbon\Carbon $oEndDate
     * @return array  result data
     */
    function zoneBannerStatistics($zoneId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('ZoneXmlRpcService.php', 'zoneBannerStatistics', $zoneId, $oStartDate,
            $oEndDate);
    }

    function linkBanner($zoneId, $bannerId)
    {
        return (bool)$this->_sendWithSession('ZoneXmlRpcService.php', 'linkBanner', [(int)$zoneId, (int)$bannerId]);
    }

    function linkCampaign($zoneId, $campaignId)
    {
        return (bool)$this->_sendWithSession('ZoneXmlRpcService.php', 'linkCampaign', [(int)$zoneId, (int)$campaignId]);
    }

    function unlinkBanner($zoneId, $bannerId)
    {
        return (bool)$this->_sendWithSession('ZoneXmlRpcService.php', 'unlinkBanner', [(int)$zoneId, (int)$bannerId]);
    }

    function unlinkCampaign($zoneId, $campaignId)
    {
        return (bool)$this->_sendWithSession('ZoneXmlRpcService.php', 'unlinkCampaign',
            [(int)$zoneId, (int)$campaignId]);
    }

    function generateTags($zoneId, $codeType, $aParams = null)
    {
        if (! isset($aParams)) {
            $aParams = [];
        }

        return $this->_sendWithSession('ZoneXmlRpcService.php', 'generateTags', [(int)$zoneId, $codeType, $aParams]);
    }
}

