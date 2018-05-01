
# Artistan/Revive-XmlRpc

remote procedure calls - RPC - is a basic API that has existed on Revive since it was OpenX Source.
This is a basic update to that system and extracted into a package which can be used in virtually any Php Project to access your Revive server or manage multiple Revive servers.
The response data is not exactly pretty for Ads Display, but hopefully I can come up with a version 3 that format the data into a more friendly format.

## Revive AdServer xml api

extracted into a package and updated to use packages rather than pear

## requires
- php-xml
- phpxmlrpc/phpxmlrpc
- carbondate/carbon

## examples

these examples were testing in Laravel 5.6 Commands

#### composer

```json
    "require": {
        "artistan/revive-xmlrpc": "*"
    }
```

#### Version 2 xml

```php

use Artistan\ReviveXmlRpc\OpenAdsV2ApiXmlRpc;
$rpc = new OpenAdsV2ApiXmlRpc('ads.me.com', '/www/api/v2/xmlrpc/', 'admin', '~test~', 0, true, 15);
$list = $rpc->getAgencyList();

```

#### Version 1 xml

```php

use Artistan\ReviveXmlRpc\OpenAdsV1ApiXmlRpc;
$rpc = new OpenAdsV1ApiXmlRpc('ads.me.com', '/www/api/v1/xmlrpc/', 'admin', '~test~', 0, true, 15);
$list = $rpc->getAgencyList();

```

#### Ad Display Retrieval xml

```php

        $rpc = new OpenAdsDisplayXmlRpc('ads.energybin.com', '/www/delivery/axmlrpc.php', 443, true, 15);
        $rpc->setRemoteInfo('remote_addr', 'chuck-dev');
        $list = $rpc->view('zone:1', 0, '', '', 0, [], '');
        var_dump(json_decode(json_encode($list),true));

```

