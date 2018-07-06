## Table of contents

- [\Artistan\ReviveXmlRpc\OpenAdsV2ApiXmlRpc](#class-artistanrevivexmlrpcopenadsv2apixmlrpc)
- [\Artistan\ReviveXmlRpc\Info (abstract)](#class-artistanrevivexmlrpcinfo-abstract)
- [\Artistan\ReviveXmlRpc\ZoneInfo](#class-artistanrevivexmlrpczoneinfo)
- [\Artistan\ReviveXmlRpc\BannerInfo](#class-artistanrevivexmlrpcbannerinfo)
- [\Artistan\ReviveXmlRpc\TrackerInfo](#class-artistanrevivexmlrpctrackerinfo)
- [\Artistan\ReviveXmlRpc\VariableInfo](#class-artistanrevivexmlrpcvariableinfo)
- [\Artistan\ReviveXmlRpc\AgencyInfo](#class-artistanrevivexmlrpcagencyinfo)
- [\Artistan\ReviveXmlRpc\XmlRpcUtils](#class-artistanrevivexmlrpcxmlrpcutils)
- [\Artistan\ReviveXmlRpc\TargetingOptions](#class-artistanrevivexmlrpctargetingoptions)
- [\Artistan\ReviveXmlRpc\TargetingInfo](#class-artistanrevivexmlrpctargetinginfo)
- [\Artistan\ReviveXmlRpc\ChannelInfo](#class-artistanrevivexmlrpcchannelinfo)
- [\Artistan\ReviveXmlRpc\UserInfo](#class-artistanrevivexmlrpcuserinfo)
- [\Artistan\ReviveXmlRpc\CampaignInfo](#class-artistanrevivexmlrpccampaigninfo)
- [\Artistan\ReviveXmlRpc\PublisherInfo](#class-artistanrevivexmlrpcpublisherinfo)
- [\Artistan\ReviveXmlRpc\AdvertiserInfo](#class-artistanrevivexmlrpcadvertiserinfo)
- [\Artistan\ReviveXmlRpc\OpenAdsV1ApiXmlRpc](#class-artistanrevivexmlrpcopenadsv1apixmlrpc)
- [\Artistan\ReviveXmlRpc\Provider](#class-artistanrevivexmlrpcprovider)
- [\Artistan\ReviveXmlRpc\OpenAdsDisplayXmlRpc](#class-artistanrevivexmlrpcopenadsdisplayxmlrpc)

<hr />

### Class: \Artistan\ReviveXmlRpc\OpenAdsV2ApiXmlRpc

> A library class to provide XML-RPC routines on a web server to enable it to manipulate objects in OpenX using the web services API.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string/array</em> <strong>$host_config=null</strong>, <em>string</em> <strong>$basepath=null</strong>, <em>string</em> <strong>$username=null</strong>, <em>string</em> <strong>$password=null</strong>, <em>int</em> <strong>$port=null</strong>, <em>bool</em> <strong>$ssl=null</strong>, <em>int</em> <strong>$timeout=null</strong>)</strong> : <em>void</em><br /><em>pass array as first parameter to load it as the config if any parameter is not set, the config method will be used to try to use config from file</em> |
| public | <strong>_callStatisticsMethod(</strong><em>string</em> <strong>$methodName</strong>, <em>int</em> <strong>$entityId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns statistics for an entity.</em> |
| public | <strong>_getClient()</strong> : <em>\PhpXmlRpc\Client</em><br /><em>A private method to return an Client to the API service</em> |
| public | <strong>_logon()</strong> : <em>boolean "Was the remote logon() call successful?"</em><br /><em>This method logs on to web services.</em> |
| public | <strong>_send(</strong><em>string</em> <strong>$method</strong>, <em>mixed</em> <strong>$data</strong>)</strong> : <em>mixed The response from the server or false in the event of failure.</em><br /><em>This function sends a method call to a specified service.</em> |
| public | <strong>_sendWithSession(</strong><em>string</em> <strong>$method</strong>, <em>array/mixed</em> <strong>$data=array()</strong>)</strong> : <em>mixed The response from the server or false in the event of failure.</em><br /><em>This private function sends a method call and $data to a specified service and automatically adds the value of the sessionID.</em> |
| public | <strong>addAdvertiser(</strong><em>[\Artistan\ReviveXmlRpc\AdvertiserInfo](#class-artistanrevivexmlrpcadvertiserinfo)</em> <strong>$oAdvertiserInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method adds an advertiser.</em> |
| public | <strong>addAgency(</strong><em>[\Artistan\ReviveXmlRpc\AgencyInfo](#class-artistanrevivexmlrpcagencyinfo)</em> <strong>$oAgencyInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method sends a call to the AgencyXmlRpcService and passes the AgencyInfo with the session to add an agency.</em> |
| public | <strong>addBanner(</strong><em>[\Artistan\ReviveXmlRpc\BannerInfo](#class-artistanrevivexmlrpcbannerinfo)</em> <strong>$oBannerInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method adds a banner to the banner object.</em> |
| public | <strong>addCampaign(</strong><em>[\Artistan\ReviveXmlRpc\CampaignInfo](#class-artistanrevivexmlrpccampaigninfo)</em> <strong>$oCampaignInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method adds a campaign to the campaign object.</em> |
| public | <strong>addChannel(</strong><em>[\Artistan\ReviveXmlRpc\ChannelInfo](#class-artistanrevivexmlrpcchannelinfo)</em> <strong>$oChannelInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method adds a channel to the channel object.</em> |
| public | <strong>addPublisher(</strong><em>[\Artistan\ReviveXmlRpc\PublisherInfo](#class-artistanrevivexmlrpcpublisherinfo)</em> <strong>$oPublisherInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method adds a publisher to the publisher object.</em> |
| public | <strong>addUser(</strong><em>[\Artistan\ReviveXmlRpc\UserInfo](#class-artistanrevivexmlrpcuserinfo)</em> <strong>$oUserInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method adds a user to the user object.</em> |
| public | <strong>addVariable(</strong><em>[\Artistan\ReviveXmlRpc\VariableInfo](#class-artistanrevivexmlrpcvariableinfo)</em> <strong>$oVariableInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method adds a variable to the variable object.</em> |
| public | <strong>addZone(</strong><em>[\Artistan\ReviveXmlRpc\ZoneInfo](#class-artistanrevivexmlrpczoneinfo)</em> <strong>$oZoneInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method adds a zone to the zone object.</em> |
| public | <strong>advertiserBannerStatistics(</strong><em>int</em> <strong>$advertiserId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns banner statistics for an advertiser for a specified period.</em> |
| public | <strong>advertiserCampaignStatistics(</strong><em>int</em> <strong>$advertiserId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns campaign statistics for an advertiser for a specified period.</em> |
| public | <strong>advertiserDailyStatistics(</strong><em>int</em> <strong>$advertiserId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns daily statistics for an advertiser for a specified period.</em> |
| public | <strong>advertiserPublisherStatistics(</strong><em>int</em> <strong>$advertiserId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns publisher statistics for an advertiser for a specified period.</em> |
| public | <strong>advertiserZoneStatistics(</strong><em>int</em> <strong>$advertiserId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns zone statistics for an advertiser for a specified period.</em> |
| public | <strong>agencyAdvertiserStatistics(</strong><em>int</em> <strong>$agencyId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns the advertiser statistics for an agency for a specified time period.</em> |
| public | <strong>agencyBannerStatistics(</strong><em>int</em> <strong>$agencyId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns the banner statistics for an agency for a specified time period.</em> |
| public | <strong>agencyCampaignStatistics(</strong><em>int</em> <strong>$agencyId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns the campaign statistics for an agency for a specified time period.</em> |
| public | <strong>agencyDailyStatistics(</strong><em>int</em> <strong>$agencyId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns the daily statistics for an agency for a specified time period.</em> |
| public | <strong>agencyPublisherStatistics(</strong><em>int</em> <strong>$agencyId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns the publisher statistics for an agency for a specified time period.</em> |
| public | <strong>agencyZoneStatistics(</strong><em>int</em> <strong>$agencyId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns the zone statistics for an agency for a specified time period.</em> |
| public | <strong>bannerDailyStatistics(</strong><em>int</em> <strong>$bannerId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns daily statistics for a banner for a specified period.</em> |
| public | <strong>bannerPublisherStatistics(</strong><em>int</em> <strong>$bannerId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns publisher statistics for a banner for a specified period.</em> |
| public | <strong>bannerZoneStatistics(</strong><em>int</em> <strong>$bannerId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns zone statistics for a banner for a specified period.</em> |
| public | <strong>campaignBannerStatistics(</strong><em>int</em> <strong>$campaignId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns banner statistics for a campaign for a specified period.</em> |
| public | <strong>campaignDailyStatistics(</strong><em>int</em> <strong>$campaignId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns daily statistics for a campaign for a specified period.</em> |
| public | <strong>campaignPublisherStatistics(</strong><em>int</em> <strong>$campaignId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns publisher statistics for a campaign for a specified period.</em> |
| public | <strong>campaignZoneStatistics(</strong><em>int</em> <strong>$campaignId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns zone statistics for a campaign for a specified period.</em> |
| public | <strong>config(</strong><em>mixed</em> <strong>$key</strong>, <em>null</em> <strong>$default=null</strong>)</strong> : <em>mixed/null</em><br /><em>get variable from config</em> |
| public | <strong>deleteAdvertiser(</strong><em>int</em> <strong>$advertiserId</strong>)</strong> : <em>mixed result</em><br /><em>This method deletes an advertiser.</em> |
| public | <strong>deleteAgency(</strong><em>int</em> <strong>$agencyId</strong>)</strong> : <em>mixed result</em><br /><em>This method deletes a specified agency.</em> |
| public | <strong>deleteBanner(</strong><em>int</em> <strong>$bannerId</strong>)</strong> : <em>mixed result</em><br /><em>This method deletes a banner from the banner object.</em> |
| public | <strong>deleteCampaign(</strong><em>int</em> <strong>$campaignId</strong>)</strong> : <em>mixed result</em><br /><em>This method deletes a campaign from the campaign object.</em> |
| public | <strong>deletePublisher(</strong><em>int</em> <strong>$publisherId</strong>)</strong> : <em>mixed result</em><br /><em>This method deletes a publisher from the publisher object.</em> |
| public | <strong>deleteUser(</strong><em>int</em> <strong>$userId</strong>)</strong> : <em>mixed result</em><br /><em>This method deletes a user from the user object.</em> |
| public | <strong>deleteZone(</strong><em>int</em> <strong>$zoneId</strong>)</strong> : <em>mixed result</em><br /><em>This method deletes a zone from the zone object.</em> |
| public | <strong>generateTags(</strong><em>int</em> <strong>$zoneId</strong>, <em>string</em> <strong>$codeType</strong>, <em>array</em> <strong>$aParams=null</strong>)</strong> : <em>bool</em><br /><em>A method to generate tags for a zone invocationTags:oxInvocationTags:adframe invocationTags:oxInvocationTags:adjs invocationTags:oxInvocationTags:adlayer invocationTags:oxInvocationTags:adview invocationTags:oxInvocationTags:adviewnocookies invocationTags:oxInvocationTags:local invocationTags:oxInvocationTags:popup invocationTags:oxInvocationTags:xmlrpc</em> |
| public | <strong>getAdvertiser(</strong><em>int</em> <strong>$advertiserId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\AdvertiserInfo](#class-artistanrevivexmlrpcadvertiserinfo)</em><br /><em>This method returns AdvertiserInfo for a specified advertiser.</em> |
| public | <strong>getAdvertiserListByAgencyId(</strong><em>int</em> <strong>$agencyId</strong>)</strong> : <em>array array AgencyInfo objects</em><br /><em>This method returns a list of advertisers by Agency ID.</em> |
| public | <strong>getAgency(</strong><em>int</em> <strong>$agencyId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\AgencyInfo](#class-artistanrevivexmlrpcagencyinfo)</em><br /><em>This method  returns the AgencyInfo for a specified agency.</em> |
| public | <strong>getAgencyList()</strong> : <em>array array AgencyInfo objects</em><br /><em>This method returns AgencyInfo for all agencies.</em> |
| public | <strong>getBanner(</strong><em>int</em> <strong>$bannerId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\BannerInfo](#class-artistanrevivexmlrpcbannerinfo)</em><br /><em>This method returns BannerInfo for a specified banner.</em> |
| public | <strong>getBannerListByCampaignId(</strong><em>int</em> <strong>$campaignId</strong>)</strong> : <em>array array CampaignInfo objects</em><br /><em>This method returns a list of banners for a specified campaign.</em> |
| public | <strong>getBannerTargeting(</strong><em>int</em> <strong>$bannerId</strong>)</strong> : <em>array</em><br /><em>This method returns TargetingInfo for a specified banner.</em> |
| public | <strong>getCampaign(</strong><em>int</em> <strong>$campaignId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\CampaignInfo](#class-artistanrevivexmlrpccampaigninfo)</em><br /><em>This method returns CampaignInfo for a specified campaign.</em> |
| public | <strong>getCampaignListByAdvertiserId(</strong><em>int</em> <strong>$advertiserId</strong>)</strong> : <em>array array CampaignInfo objects</em><br /><em>This method returns a list of campaigns for an advertiser.</em> |
| public | <strong>getChannel(</strong><em>int</em> <strong>$channelId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\ChannelInfo](#class-artistanrevivexmlrpcchannelinfo)</em><br /><em>This method returns ChannelInfo for a specified channel.</em> |
| public | <strong>getChannelListByAgencyId(</strong><em>int</em> <strong>$agencyId</strong>)</strong> : <em>array array ChannelInfo objects</em><br /><em>This method returns a list of channels by Agency ID.</em> |
| public | <strong>getChannelListByWebsiteId(</strong><em>int</em> <strong>$websiteId</strong>)</strong> : <em>array array ChannelInfo objects</em><br /><em>This method returns a list of channels by Website ID.</em> |
| public | <strong>getChannelTargeting(</strong><em>int</em> <strong>$channelId</strong>)</strong> : <em>array</em><br /><em>This method returns TargetingInfo for a specified channel.</em> |
| public | <strong>getPublisher(</strong><em>int</em> <strong>$publisherId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\PublisherInfo](#class-artistanrevivexmlrpcpublisherinfo)</em><br /><em>This method returns PublisherInfo for a specified publisher.</em> |
| public | <strong>getPublisherListByAgencyId(</strong><em>int</em> <strong>$agencyId</strong>)</strong> : <em>array array PublisherInfo objects</em><br /><em>This method returns a list of publishers for a specified agency.</em> |
| public | <strong>getUser(</strong><em>int</em> <strong>$userId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\UserInfo](#class-artistanrevivexmlrpcuserinfo)</em><br /><em>This method returns UserInfo for a specified user.</em> |
| public | <strong>getUserListByAccountId(</strong><em>int</em> <strong>$accountId</strong>)</strong> : <em>array array UserInfo objects</em><br /><em>This method returns a list of users by Account ID.</em> |
| public | <strong>getVariable(</strong><em>int</em> <strong>$variableId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\VariableInfo](#class-artistanrevivexmlrpcvariableinfo)</em><br /><em>This method returns VariableInfo for a specified variable.</em> |
| public | <strong>getZone(</strong><em>int</em> <strong>$zoneId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\ZoneInfo](#class-artistanrevivexmlrpczoneinfo)</em><br /><em>This method returns ZoneInfo for a specified zone.</em> |
| public | <strong>getZoneListByPublisherId(</strong><em>int</em> <strong>$publisherId</strong>)</strong> : <em>array array ZoneInfo objects</em><br /><em>This method returns a list of zones for a specified publisher.</em> |
| public | <strong>linkBanner(</strong><em>int</em> <strong>$zoneId</strong>, <em>int</em> <strong>$bannerId</strong>)</strong> : <em>bool</em><br /><em>A method to link a banner to a zone</em> |
| public | <strong>linkCampaign(</strong><em>int</em> <strong>$zoneId</strong>, <em>int</em> <strong>$campaignId</strong>)</strong> : <em>bool</em><br /><em>A method to link a campaign to a zone</em> |
| public | <strong>load_config(</strong><em>mixed</em> <strong>$config</strong>)</strong> : <em>mixed</em><br /><em>pass a configuration array to the class directory</em> |
| public | <strong>logoff()</strong> : <em>boolean "Was the remote logoff() call successful?"</em><br /><em>This method logs off from web wervices.</em> |
| public | <strong>modifyAdvertiser(</strong><em>[\Artistan\ReviveXmlRpc\AdvertiserInfo](#class-artistanrevivexmlrpcadvertiserinfo)</em> <strong>$oAdvertiserInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method modifies an advertiser.</em> |
| public | <strong>modifyAgency(</strong><em>[\Artistan\ReviveXmlRpc\AgencyInfo](#class-artistanrevivexmlrpcagencyinfo)</em> <strong>$oAgencyInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method sends a call to the AgencyXmlRpcService and passes the AgencyInfo object with the session to modify an agency.</em> |
| public | <strong>modifyBanner(</strong><em>[\Artistan\ReviveXmlRpc\BannerInfo](#class-artistanrevivexmlrpcbannerinfo)</em> <strong>$oBannerInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method modifies a banner.</em> |
| public | <strong>modifyCampaign(</strong><em>[\Artistan\ReviveXmlRpc\CampaignInfo](#class-artistanrevivexmlrpccampaigninfo)</em> <strong>$oCampaignInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method modifies a campaign.</em> |
| public | <strong>modifyChannel(</strong><em>[\Artistan\ReviveXmlRpc\ChannelInfo](#class-artistanrevivexmlrpcchannelinfo)</em> <strong>$oChannelInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method modifies a channel.</em> |
| public | <strong>modifyPublisher(</strong><em>[\Artistan\ReviveXmlRpc\PublisherInfo](#class-artistanrevivexmlrpcpublisherinfo)</em> <strong>$oPublisherInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method modifies a publisher.</em> |
| public | <strong>modifyUser(</strong><em>[\Artistan\ReviveXmlRpc\UserInfo](#class-artistanrevivexmlrpcuserinfo)</em> <strong>$oUserInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method modifies a user.</em> |
| public | <strong>modifyVariable(</strong><em>[\Artistan\ReviveXmlRpc\VariableInfo](#class-artistanrevivexmlrpcvariableinfo)</em> <strong>$oVariableInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method modifies a variable.</em> |
| public | <strong>modifyZone(</strong><em>[\Artistan\ReviveXmlRpc\ZoneInfo](#class-artistanrevivexmlrpczoneinfo)</em> <strong>$oZoneInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method modifies a zone.</em> |
| public | <strong>publisherAdvertiserStatistics(</strong><em>int</em> <strong>$publisherId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns advertiser statistics for a specified period.</em> |
| public | <strong>publisherBannerStatistics(</strong><em>int</em> <strong>$publisherId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns banner statistics for a publisher for a specified period.</em> |
| public | <strong>publisherCampaignStatistics(</strong><em>int</em> <strong>$publisherId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns campaign statistics for a publisher for a specified period.</em> |
| public | <strong>publisherDailyStatistics(</strong><em>int</em> <strong>$publisherId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns daily statistics for a publisher for a specified period.</em> |
| public | <strong>publisherZoneStatistics(</strong><em>int</em> <strong>$publisherId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns zone statistics for a publisher for a specified period.</em> |
| public | <strong>setBannerTargeting(</strong><em>integer</em> <strong>$bannerId</strong>, <em>array</em> <strong>$aTargeting</strong>)</strong> : <em>bool</em><br /><em>This method takes an array of targeting info objects and a banner id and sets the targeting for the banner to the values passed in</em> |
| public | <strong>setChannelTargeting(</strong><em>integer</em> <strong>$channelId</strong>, <em>array</em> <strong>$aTargeting</strong>)</strong> : <em>bool</em><br /><em>This method takes an array of targeting info objects and a channel id and sets the targeting for the channel to the values passed in</em> |
| public | <strong>unlinkBanner(</strong><em>int</em> <strong>$zoneId</strong>, <em>int</em> <strong>$bannerId</strong>)</strong> : <em>bool</em><br /><em>A method to unlink a banner from a zone</em> |
| public | <strong>unlinkCampaign(</strong><em>int</em> <strong>$zoneId</strong>, <em>int</em> <strong>$campaignId</strong>)</strong> : <em>bool</em><br /><em>A method to unlink a campaign from a zone</em> |
| public | <strong>updateSsoChannelId(</strong><em>int</em> <strong>$oldSsoChannelId</strong>, <em>int</em> <strong>$newSsoChannelId</strong>)</strong> : <em>bool</em><br /><em>This method updates channels SSO Channel Id</em> |
| public | <strong>updateSsoUserId(</strong><em>int</em> <strong>$oldSsoUserId</strong>, <em>int</em> <strong>$newSsoUserId</strong>)</strong> : <em>bool</em><br /><em>This method updates users SSO User Id</em> |
| public | <strong>updateUserEmailBySsoId(</strong><em>int</em> <strong>$ssoUserId</strong>, <em>string</em> <strong>$email</strong>)</strong> : <em>bool</em><br /><em>This method updates users email by his SSO User Id</em> |
| public | <strong>zoneAdvertiserStatistics(</strong><em>int</em> <strong>$zoneId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns advertiser statistics for a zone for a specified period.</em> |
| public | <strong>zoneBannerStatistics(</strong><em>int</em> <strong>$zoneId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns publisher statistics for a zone for a specified period.</em> |
| public | <strong>zoneCampaignStatistics(</strong><em>int</em> <strong>$zoneId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns campaign statistics for a zone for a specified period.</em> |
| public | <strong>zoneDailyStatistics(</strong><em>int</em> <strong>$zoneId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>, <em>bool/boolean</em> <strong>$useManagerTimezone=false</strong>)</strong> : <em>array result data</em><br /><em>This method returns daily statistics for a zone for a specified period.</em> |

<hr />

### Class: \Artistan\ReviveXmlRpc\Info (abstract)

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>array</em> <strong>$aEntityData=array()</strong>)</strong> : <em>void</em> |
| public | <strong>getFieldType(</strong><em>mixed</em> <strong>$fieldName</strong>)</strong> : <em>mixed</em><br /><em>get RPCdataType for field</em> |
| public | <strong>abstract getFieldsTypes()</strong> : <em>array ['fieldName' +> 'RPCdataType', ...]</em><br /><em>get field type definition</em> |
| public | <strong>readDataFromArray(</strong><em>array</em> <strong>$aEntityData</strong>)</strong> : <em>void</em><br /><em>create/build $this from array data</em> |
| public | <strong>toArray()</strong> : <em>array</em> |

<hr />

### Class: \Artistan\ReviveXmlRpc\ZoneInfo

> The ZoneInfo class extends the base Info class and contains information about the zone.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getFieldsTypes()</strong> : <em>array</em><br /><em>This method returns an array of fields with their corresponding types.</em> |
| public | <strong>setDefaultForAdd()</strong> : <em>void</em><br /><em>This method sets all default values when adding a new zone.</em> |

*This class extends [\Artistan\ReviveXmlRpc\Info](#class-artistanrevivexmlrpcinfo-abstract)*

<hr />

### Class: \Artistan\ReviveXmlRpc\BannerInfo

> The BannerInfo class extends the base Info class and contains information about the banner.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>encodeImage(</strong><em>mixed</em> <strong>$aImage</strong>)</strong> : <em>void</em> |
| public | <strong>getFieldsTypes()</strong> : <em>array</em><br /><em>This method returns an array of fields with their corresponding types.</em> |
| public | <strong>setDefaultForAdd()</strong> : <em>void</em><br /><em>This method sets all default values when adding a new banner.</em> |
| public | <strong>toArray()</strong> : <em>void</em> |

*This class extends [\Artistan\ReviveXmlRpc\Info](#class-artistanrevivexmlrpcinfo-abstract)*

<hr />

### Class: \Artistan\ReviveXmlRpc\TrackerInfo

> The TrackerInfo class extends the base Info class and contains information about tracker

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getFieldsTypes()</strong> : <em>array</em><br /><em>This method returns an array of fields with their corresponding types.</em> |

*This class extends [\Artistan\ReviveXmlRpc\Info](#class-artistanrevivexmlrpcinfo-abstract)*

<hr />

### Class: \Artistan\ReviveXmlRpc\VariableInfo

> The VariableInfo class extends the base Info class and contains information about variable

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getFieldsTypes()</strong> : <em>array</em><br /><em>This method returns an array of fields with their corresponding types.</em> |

*This class extends [\Artistan\ReviveXmlRpc\Info](#class-artistanrevivexmlrpcinfo-abstract)*

<hr />

### Class: \Artistan\ReviveXmlRpc\AgencyInfo

> The agencyInfo class extends the base Info class and contains information about the agency.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getFieldsTypes()</strong> : <em>array</em><br /><em>This method returns an array of fields with their corresponding types.</em> |

*This class extends [\Artistan\ReviveXmlRpc\Info](#class-artistanrevivexmlrpcinfo-abstract)*

<hr />

### Class: \Artistan\ReviveXmlRpc\XmlRpcUtils

> The XmlRpcUtils class contains various XmlRpc methods.

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>dateObject(</strong><em>mixed</em> <strong>$date</strong>)</strong> : <em>\Carbon\Carbon/null</em> |
| public static | <strong>getEntityWithNotNullFields(</strong><em>mixed</em> <strong>$oInfoObject</strong>)</strong> : <em>\PhpXmlRpc\Value</em><br /><em>This method converts the Info object into an Value and deletes null fields.</em> |
| public static | <strong>getRPCTypeForField(</strong><em>string</em> <strong>$type</strong>, <em>mixed</em> <strong>$variable</strong>)</strong> : <em>\PhpXmlRpc\Value or false</em><br /><em>This method sets the RPC type for variables.</em> |

<hr />

### Class: \Artistan\ReviveXmlRpc\TargetingOptions

> The TargetingOptions class contains options information about targeting

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>clientType(</strong><em>mixed</em> <strong>$data</strong>)</strong> : <em>bool/string</em><br /><em>get client type key</em> |
| public static | <strong>comparison(</strong><em>string</em> <strong>$data=`''`</strong>)</strong> : <em>mixed/string</em><br /><em>get comparison key returns the default value if no match</em> |
| public static | <strong>continent(</strong><em>string</em> <strong>$data=`''`</strong>)</strong> : <em>mixed/string</em><br /><em>get continent key returns the empty value if no match</em> |
| public static | <strong>country(</strong><em>string</em> <strong>$data=`''`</strong>)</strong> : <em>mixed/string</em><br /><em>get country key returns the empty value if no match</em> |
| public static | <strong>geoType(</strong><em>mixed</em> <strong>$data</strong>)</strong> : <em>bool/string</em><br /><em>get geo type key</em> |
| public static | <strong>getDeliveryType(</strong><em>mixed</em> <strong>$type</strong>, <em>mixed</em> <strong>$data</strong>)</strong> : <em>bool/string</em><br /><em>get site type key</em> |
| public static | <strong>logical(</strong><em>string</em> <strong>$data=`''`</strong>)</strong> : <em>mixed/string</em><br /><em>get logical key returns the default value if no match</em> |
| public static | <strong>siteType(</strong><em>mixed</em> <strong>$data</strong>)</strong> : <em>bool/string</em><br /><em>get site type key</em> |

<hr />

### Class: \Artistan\ReviveXmlRpc\TargetingInfo

> The TargetingInfo class extends the base Info class and contains information about targeting

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getFieldsTypes()</strong> : <em>array</em><br /><em>This method returns an array of fields with their corresponding types.</em> |
| public static | <strong>getSettings(</strong><em>string</em> <strong>$csvFilter=`'EU'`</strong>, <em>string</em> <strong>$delivery_data=`'Continent'`</strong>, <em>string</em> <strong>$delivery_type=`'Geo'`</strong>, <em>string</em> <strong>$comparison=`'=~'`</strong>, <em>string</em> <strong>$logical=`'and'`</strong>)</strong> : <em>array</em><br /><em>quick settings for channel targeting</em> |
###### Examples of TargetingInfo::getSettings()
```
$targeting[] = TargetingInfo::getSettings();
$targeting[] = TargetingInfo::getSettings('US','Country');
$targeting[] = TargetingInfo::getSettings('KeyHere','Source','Site','==','or');
$rpc->setChannelTargeting($channel_id,$targeting);
/example
```

*This class extends [\Artistan\ReviveXmlRpc\Info](#class-artistanrevivexmlrpcinfo-abstract)*

<hr />

### Class: \Artistan\ReviveXmlRpc\ChannelInfo

> The channelInfo class extends the base Info class and contains information about the channel.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getFieldsTypes()</strong> : <em>array</em><br /><em>This method returns an array of fields with their corresponding types.</em> |

*This class extends [\Artistan\ReviveXmlRpc\Info](#class-artistanrevivexmlrpcinfo-abstract)*

<hr />

### Class: \Artistan\ReviveXmlRpc\UserInfo

> The UserInfo class extends the base Info class and contains information about the user.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getFieldsTypes()</strong> : <em>array</em><br /><em>This method returns an array of fields with their corresponding types.</em> |

*This class extends [\Artistan\ReviveXmlRpc\Info](#class-artistanrevivexmlrpcinfo-abstract)*

<hr />

### Class: \Artistan\ReviveXmlRpc\CampaignInfo

> The campaignInfo class extends the base Info class and contains information about the campaign.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getFieldsTypes()</strong> : <em>array</em><br /><em>This method returns an array of fields with their corresponding types.</em> |
| public | <strong>setDefaultForAdd()</strong> : <em>void</em><br /><em>This function sets all default values when adding new campaign.</em> |

*This class extends [\Artistan\ReviveXmlRpc\Info](#class-artistanrevivexmlrpcinfo-abstract)*

<hr />

### Class: \Artistan\ReviveXmlRpc\PublisherInfo

> The PublisherInfo class extends the base Info class and contains information about the publisher.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getFieldsTypes()</strong> : <em>array</em><br /><em>This method returns an array of fields with their corresponding types.</em> |

*This class extends [\Artistan\ReviveXmlRpc\Info](#class-artistanrevivexmlrpcinfo-abstract)*

<hr />

### Class: \Artistan\ReviveXmlRpc\AdvertiserInfo

> The AdvertiserInfo class extends the base Info class and contains information about advertisers. Advertiser is the

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getFieldsTypes()</strong> : <em>array</em><br /><em>This method returns an array of fields with their corresponding types.</em> |

*This class extends [\Artistan\ReviveXmlRpc\Info](#class-artistanrevivexmlrpcinfo-abstract)*

<hr />

### Class: \Artistan\ReviveXmlRpc\OpenAdsV1ApiXmlRpc

> A library class to provide XML-RPC routines on a web server to enable it to manipulate objects in OpenX using the web services API.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string</em> <strong>$host</strong>, <em>string</em> <strong>$basepath</strong>, <em>string</em> <strong>$username</strong>, <em>string</em> <strong>$password</strong>, <em>int</em> <strong>$port</strong>, <em>bool</em> <strong>$ssl=false</strong>, <em>int</em> <strong>$timeout=15</strong>)</strong> : <em>void</em><br /><em>are port 80 for HTTP and port 443 for HTTPS.</em> |
| public | <strong>_callStatisticsMethod(</strong><em>string</em> <strong>$serviceFileName</strong>, <em>string</em> <strong>$methodName</strong>, <em>int</em> <strong>$entityId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns statistics for an entity.</em> |
| public | <strong>_getClient(</strong><em>string</em> <strong>$service</strong>)</strong> : <em>\PhpXmlRpc\Client</em><br /><em>A private method to return an Client to the API service</em> |
| public | <strong>_logon()</strong> : <em>boolean "Was the remote logon() call successful?"</em><br /><em>This method logs on to web services.</em> |
| public | <strong>_send(</strong><em>string</em> <strong>$service</strong>, <em>string</em> <strong>$method</strong>, <em>mixed</em> <strong>$data</strong>)</strong> : <em>mixed The response from the server or false in the event of failure.</em><br /><em>This function sends a method call to a specified service.</em> |
| public | <strong>_sendWithSession(</strong><em>string</em> <strong>$service</strong>, <em>string</em> <strong>$method</strong>, <em>array/mixed</em> <strong>$data=array()</strong>)</strong> : <em>mixed The response from the server or false in the event of failure.</em><br /><em>This private function sends a method call and $data to a specified service and automatically adds the value of the sessionID.</em> |
| public | <strong>addAdvertiser(</strong><em>[\Artistan\ReviveXmlRpc\AdvertiserInfo](#class-artistanrevivexmlrpcadvertiserinfo)</em> <strong>$oAdvertiserInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method adds an advertiser.</em> |
| public | <strong>addAgency(</strong><em>[\Artistan\ReviveXmlRpc\AgencyInfo](#class-artistanrevivexmlrpcagencyinfo)</em> <strong>$oAgencyInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method sends a call to the AgencyXmlRpcService and passes the AgencyInfo with the session to add an agency.</em> |
| public | <strong>addBanner(</strong><em>[\Artistan\ReviveXmlRpc\BannerInfo](#class-artistanrevivexmlrpcbannerinfo)</em> <strong>$oBannerInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method adds a banner to the banner object.</em> |
| public | <strong>addCampaign(</strong><em>[\Artistan\ReviveXmlRpc\CampaignInfo](#class-artistanrevivexmlrpccampaigninfo)</em> <strong>$oCampaignInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method adds a campaign to the campaign object.</em> |
| public | <strong>addPublisher(</strong><em>[\Artistan\ReviveXmlRpc\PublisherInfo](#class-artistanrevivexmlrpcpublisherinfo)</em> <strong>$oPublisherInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method adds a publisher to the publisher object.</em> |
| public | <strong>addUser(</strong><em>[\Artistan\ReviveXmlRpc\UserInfo](#class-artistanrevivexmlrpcuserinfo)</em> <strong>$oUserInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method adds a user to the user object.</em> |
| public | <strong>addZone(</strong><em>[\Artistan\ReviveXmlRpc\ZoneInfo](#class-artistanrevivexmlrpczoneinfo)</em> <strong>$oZoneInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method adds a zone to the zone object.</em> |
| public | <strong>advertiserBannerStatistics(</strong><em>int</em> <strong>$advertiserId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns banner statistics for an advertiser for a specified period.</em> |
| public | <strong>advertiserCampaignStatistics(</strong><em>int</em> <strong>$advertiserId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns campaign statistics for an advertiser for a specified period.</em> |
| public | <strong>advertiserDailyStatistics(</strong><em>int</em> <strong>$advertiserId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns daily statistics for an advertiser for a specified period.</em> |
| public | <strong>advertiserPublisherStatistics(</strong><em>int</em> <strong>$advertiserId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns publisher statistics for an advertiser for a specified period.</em> |
| public | <strong>advertiserZoneStatistics(</strong><em>int</em> <strong>$advertiserId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns zone statistics for an advertiser for a specified period.</em> |
| public | <strong>agencyAdvertiserStatistics(</strong><em>int</em> <strong>$agencyId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns the advertiser statistics for an agency for a specified time period.</em> |
| public | <strong>agencyBannerStatistics(</strong><em>int</em> <strong>$agencyId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns the banner statistics for an agency for a specified time period.</em> |
| public | <strong>agencyCampaignStatistics(</strong><em>int</em> <strong>$agencyId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns the campaign statistics for an agency for a specified time period.</em> |
| public | <strong>agencyDailyStatistics(</strong><em>int</em> <strong>$agencyId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns the daily statistics for an agency for a specified time period.</em> |
| public | <strong>agencyPublisherStatistics(</strong><em>int</em> <strong>$agencyId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns the publisher statistics for an agency for a specified time period.</em> |
| public | <strong>agencyZoneStatistics(</strong><em>int</em> <strong>$agencyId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns the zone statistics for an agency for a specified time period.</em> |
| public | <strong>bannerDailyStatistics(</strong><em>int</em> <strong>$bannerId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns daily statistics for a banner for a specified period.</em> |
| public | <strong>bannerPublisherStatistics(</strong><em>int</em> <strong>$bannerId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns publisher statistics for a banner for a specified period.</em> |
| public | <strong>bannerZoneStatistics(</strong><em>int</em> <strong>$bannerId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns zone statistics for a banner for a specified period.</em> |
| public | <strong>campaignBannerStatistics(</strong><em>int</em> <strong>$campaignId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns banner statistics for a campaign for a specified period.</em> |
| public | <strong>campaignDailyStatistics(</strong><em>int</em> <strong>$campaignId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns daily statistics for a campaign for a specified period.</em> |
| public | <strong>campaignPublisherStatistics(</strong><em>int</em> <strong>$campaignId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns publisher statistics for a campaign for a specified period.</em> |
| public | <strong>campaignZoneStatistics(</strong><em>int</em> <strong>$campaignId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns zone statistics for a campaign for a specified period.</em> |
| public | <strong>deleteAdvertiser(</strong><em>int</em> <strong>$advertiserId</strong>)</strong> : <em>mixed result</em><br /><em>This method deletes an advertiser.</em> |
| public | <strong>deleteAgency(</strong><em>int</em> <strong>$agencyId</strong>)</strong> : <em>mixed result</em><br /><em>This method deletes a specified agency.</em> |
| public | <strong>deleteBanner(</strong><em>int</em> <strong>$bannerId</strong>)</strong> : <em>mixed result</em><br /><em>This method deletes a banner from the banner object.</em> |
| public | <strong>deleteCampaign(</strong><em>int</em> <strong>$campaignId</strong>)</strong> : <em>mixed result</em><br /><em>This method deletes a campaign from the campaign object.</em> |
| public | <strong>deletePublisher(</strong><em>int</em> <strong>$publisherId</strong>)</strong> : <em>mixed result</em><br /><em>This method deletes a publisher from the publisher object.</em> |
| public | <strong>deleteUser(</strong><em>int</em> <strong>$userId</strong>)</strong> : <em>mixed result</em><br /><em>This method deletes a user from the user object.</em> |
| public | <strong>deleteZone(</strong><em>int</em> <strong>$zoneId</strong>)</strong> : <em>mixed result</em><br /><em>This method deletes a zone from the zone object.</em> |
| public | <strong>generateTags(</strong><em>mixed</em> <strong>$zoneId</strong>, <em>mixed</em> <strong>$codeType</strong>, <em>mixed</em> <strong>$aParams=null</strong>)</strong> : <em>void</em> |
| public | <strong>getAdvertiser(</strong><em>int</em> <strong>$advertiserId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\AdvertiserInfo](#class-artistanrevivexmlrpcadvertiserinfo)</em><br /><em>This method returns AdvertiserInfo for a specified advertiser.</em> |
| public | <strong>getAdvertiserListByAgencyId(</strong><em>int</em> <strong>$agencyId</strong>)</strong> : <em>array array AgencyInfo objects</em><br /><em>This method returns a list of advertisers by Agency ID.</em> |
| public | <strong>getAgency(</strong><em>int</em> <strong>$agencyId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\AgencyInfo](#class-artistanrevivexmlrpcagencyinfo)</em><br /><em>This method  returns the AgencyInfo for a specified agency.</em> |
| public | <strong>getAgencyList()</strong> : <em>array array AgencyInfo objects</em><br /><em>This method returns AgencyInfo for all agencies.</em> |
| public | <strong>getBanner(</strong><em>int</em> <strong>$bannerId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\BannerInfo](#class-artistanrevivexmlrpcbannerinfo)</em><br /><em>This method returns BannerInfo for a specified banner.</em> |
| public | <strong>getBannerListByCampaignId(</strong><em>int</em> <strong>$campaignId</strong>)</strong> : <em>array array CampaignInfo objects</em><br /><em>This method returns a list of banners for a specified campaign.</em> |
| public | <strong>getBannerTargeting(</strong><em>int</em> <strong>$bannerId</strong>)</strong> : <em>array</em><br /><em>This method returns TargetingInfo for a specified banner.</em> |
| public | <strong>getCampaign(</strong><em>int</em> <strong>$campaignId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\CampaignInfo](#class-artistanrevivexmlrpccampaigninfo)</em><br /><em>This method returns CampaignInfo for a specified campaign.</em> |
| public | <strong>getCampaignListByAdvertiserId(</strong><em>int</em> <strong>$advertiserId</strong>)</strong> : <em>array array CampaignInfo objects</em><br /><em>This method returns a list of campaigns for an advertiser.</em> |
| public | <strong>getPublisher(</strong><em>int</em> <strong>$publisherId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\PublisherInfo](#class-artistanrevivexmlrpcpublisherinfo)</em><br /><em>This method returns PublisherInfo for a specified publisher.</em> |
| public | <strong>getPublisherListByAgencyId(</strong><em>int</em> <strong>$agencyId</strong>)</strong> : <em>array array PublisherInfo objects</em><br /><em>This method returns a list of publishers for a specified agency.</em> |
| public | <strong>getUser(</strong><em>int</em> <strong>$userId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\UserInfo](#class-artistanrevivexmlrpcuserinfo)</em><br /><em>This method returns UserInfo for a specified user.</em> |
| public | <strong>getUserListByAccountId(</strong><em>int</em> <strong>$accountId</strong>)</strong> : <em>array array UserInfo objects</em><br /><em>This method returns a list of users by Account ID.</em> |
| public | <strong>getZone(</strong><em>int</em> <strong>$zoneId</strong>)</strong> : <em>[\Artistan\ReviveXmlRpc\ZoneInfo](#class-artistanrevivexmlrpczoneinfo)</em><br /><em>This method returns ZoneInfo for a specified zone.</em> |
| public | <strong>getZoneListByPublisherId(</strong><em>int</em> <strong>$publisherId</strong>)</strong> : <em>array array ZoneInfo objects</em><br /><em>This method returns a list of zones for a specified publisher.</em> |
| public | <strong>linkBanner(</strong><em>mixed</em> <strong>$zoneId</strong>, <em>mixed</em> <strong>$bannerId</strong>)</strong> : <em>void</em> |
| public | <strong>linkCampaign(</strong><em>mixed</em> <strong>$zoneId</strong>, <em>mixed</em> <strong>$campaignId</strong>)</strong> : <em>void</em> |
| public | <strong>logoff()</strong> : <em>boolean "Was the remote logoff() call successful?"</em><br /><em>This method logs off from web wervices.</em> |
| public | <strong>modifyAdvertiser(</strong><em>[\Artistan\ReviveXmlRpc\AdvertiserInfo](#class-artistanrevivexmlrpcadvertiserinfo)</em> <strong>$oAdvertiserInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method modifies an advertiser.</em> |
| public | <strong>modifyAgency(</strong><em>[\Artistan\ReviveXmlRpc\AgencyInfo](#class-artistanrevivexmlrpcagencyinfo)</em> <strong>$oAgencyInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method sends a call to the AgencyXmlRpcService and passes the AgencyInfo object with the session to modify an agency.</em> |
| public | <strong>modifyBanner(</strong><em>[\Artistan\ReviveXmlRpc\BannerInfo](#class-artistanrevivexmlrpcbannerinfo)</em> <strong>$oBannerInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method modifies a banner.</em> |
| public | <strong>modifyCampaign(</strong><em>[\Artistan\ReviveXmlRpc\CampaignInfo](#class-artistanrevivexmlrpccampaigninfo)</em> <strong>$oCampaignInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method modifies a campaign.</em> |
| public | <strong>modifyPublisher(</strong><em>[\Artistan\ReviveXmlRpc\PublisherInfo](#class-artistanrevivexmlrpcpublisherinfo)</em> <strong>$oPublisherInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method modifies a publisher.</em> |
| public | <strong>modifyUser(</strong><em>[\Artistan\ReviveXmlRpc\UserInfo](#class-artistanrevivexmlrpcuserinfo)</em> <strong>$oUserInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method modifies a user.</em> |
| public | <strong>modifyZone(</strong><em>[\Artistan\ReviveXmlRpc\ZoneInfo](#class-artistanrevivexmlrpczoneinfo)</em> <strong>$oZoneInfo</strong>)</strong> : <em>mixed result</em><br /><em>This method modifies a zone.</em> |
| public | <strong>publisherAdvertiserStatistics(</strong><em>int</em> <strong>$publisherId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns advertiser statistics for a specified period.</em> |
| public | <strong>publisherBannerStatistics(</strong><em>int</em> <strong>$publisherId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns banner statistics for a publisher for a specified period.</em> |
| public | <strong>publisherCampaignStatistics(</strong><em>int</em> <strong>$publisherId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns campaign statistics for a publisher for a specified period.</em> |
| public | <strong>publisherDailyStatistics(</strong><em>int</em> <strong>$publisherId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns daily statistics for a publisher for a specified period.</em> |
| public | <strong>publisherZoneStatistics(</strong><em>int</em> <strong>$publisherId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns zone statistics for a publisher for a specified period.</em> |
| public | <strong>setBannerTargeting(</strong><em>integer</em> <strong>$bannerId</strong>, <em>array</em> <strong>$aTargeting</strong>)</strong> : <em>bool</em><br /><em>This method takes an array of targeting info objects and a banner id and sets the targeting for the banner to the values passed in</em> |
| public | <strong>unlinkBanner(</strong><em>mixed</em> <strong>$zoneId</strong>, <em>mixed</em> <strong>$bannerId</strong>)</strong> : <em>void</em> |
| public | <strong>unlinkCampaign(</strong><em>mixed</em> <strong>$zoneId</strong>, <em>mixed</em> <strong>$campaignId</strong>)</strong> : <em>void</em> |
| public | <strong>updateSsoUserId(</strong><em>int</em> <strong>$oldSsoUserId</strong>, <em>int</em> <strong>$newSsoUserId</strong>)</strong> : <em>bool</em><br /><em>This method updates users SSO User Id</em> |
| public | <strong>updateUserEmailBySsoId(</strong><em>int</em> <strong>$ssoUserId</strong>, <em>string</em> <strong>$email</strong>)</strong> : <em>bool</em><br /><em>This method updates users email by his SSO User Id</em> |
| public | <strong>zoneAdvertiserStatistics(</strong><em>int</em> <strong>$zoneId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns advertiser statistics for a zone for a specified period.</em> |
| public | <strong>zoneBannerStatistics(</strong><em>int</em> <strong>$zoneId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns publisher statistics for a zone for a specified period.</em> |
| public | <strong>zoneCampaignStatistics(</strong><em>int</em> <strong>$zoneId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns campaign statistics for a zone for a specified period.</em> |
| public | <strong>zoneDailyStatistics(</strong><em>int</em> <strong>$zoneId</strong>, <em>\Carbon\Carbon</em> <strong>$oStartDate=null</strong>, <em>\Carbon\Carbon</em> <strong>$oEndDate=null</strong>)</strong> : <em>array result data</em><br /><em>This method returns daily statistics for a zone for a specified period.</em> |

<hr />

### Class: \Artistan\ReviveXmlRpc\Provider

> Class Provider

| Visibility | Function |
|:-----------|:---------|
| public | <strong>boot()</strong> : <em>void</em><br /><em>Alias the services in the boot.</em> |
| public | <strong>register()</strong> : <em>void</em><br /><em>Register the services.</em> |

*This class extends \Illuminate\Support\ServiceProvider*

<hr />

### Class: \Artistan\ReviveXmlRpc\OpenAdsDisplayXmlRpc

> A library class to provide XML-RPC routines  to display ads on pages on a web server where OpenX is not installed but is installed on a remote server. For use with OpenX PHP-based XML-RPC invocation tags.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string</em> <strong>$host</strong>, <em>string</em> <strong>$path</strong>, <em>int</em> <strong>$port</strong>, <em>bool</em> <strong>$ssl=false</strong>, <em>int</em> <strong>$timeout=15</strong>)</strong> : <em>void</em><br /><em>PHP5 style constructor port 80 for HTTP and port 443 for HTTPS.</em> |
| public | <strong>_convertEncoding(</strong><em>mixed</em> <strong>$content</strong>, <em>string</em> <strong>$toEncoding</strong>, <em>string</em> <strong>$fromEncoding=`'UTF-8'`</strong>, <em>string</em> <strong>$aExtensions=null</strong>)</strong> : <em>mixed The converted string, or converted string within array.</em><br /><em>A function to convert a string from one encoding to another using any available extensions returns the string unchanged if no suitable libraries are available The function will recursively walk arrays.</em> |
| public | <strong>setRemoteInfo(</strong><em>mixed</em> <strong>$key</strong>, <em>mixed</em> <strong>$value</strong>)</strong> : <em>void</em> |
| public | <strong>spc(</strong><em>mixed</em> <strong>$what</strong>, <em>string</em> <strong>$target=`''`</strong>, <em>string</em> <strong>$source=`''`</strong>, <em>mixed</em> <strong>$withtext</strong>, <em>mixed</em> <strong>$block</strong>, <em>mixed</em> <strong>$blockcampaign</strong>, <em>string</em> <strong>$charset=`''`</strong>)</strong> : <em>void</em> |
| public | <strong>view(</strong><em>string</em> <strong>$what=`''`</strong>, <em>int</em> <strong>$campaignid</strong>, <em>string</em> <strong>$target=`''`</strong>, <em>string</em> <strong>$source=`''`</strong>, <em>bool</em> <strong>$withText=false</strong>, <em>array</em> <strong>$context=array()</strong>, <em>string</em> <strong>$charset=`''`</strong>)</strong> : <em>array</em><br /><em>This method retrieves a banner from a remote OpenX installation using XML-RPC.</em> |

