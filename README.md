
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

##### laravel config/env 

```bash
php artisan vendor:publish --provider=artistan/revive-xmlrpc
```

you can edit the `config/revive-xmlrpc.php` file add these env variables to or .env files

```dotenv
RVRPC_HOST=ads.me.com
RVRPC_BASEPATH=/api/v2/xmlrpc/
RVRPC_USERNAME=admin
RVRPC_PASSWORD=~test~
RVRPC_PORT=0
RVRPC_SSL=1
RVRPC_TIMEOUT=15
```


```php
use Artistan\ReviveXmlRpc\OpenAdsV2ApiXmlRpc;
$rpc = new OpenAdsV2ApiXmlRpc();
$list = $rpc->getAgencyList();
```

##### custom config initialization

uses `./Assets/Config/revive-xmlrpc.php` for config if you do not provide it to the class.

```php
use Artistan\ReviveXmlRpc\OpenAdsV2ApiXmlRpc;

$config = [
	'host'=>'ads.me.com', 
	'basepath'=>'/www/api/v2/xmlrpc/',
	'username'=>'admin', 
	'password'=>'~test~', 
	'port'=>0, 
	'ssl'=>true, 
	'timeout'=>15
]


$rpc = new OpenAdsV2ApiXmlRpc($config);
$list = $rpc->getAgencyList();
```


##### full initialization

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
        $rpc = new OpenAdsDisplayXmlRpc('ads.me.com', '/www/delivery/axmlrpc.php', 443, true, 15);
        $rpc->setRemoteInfo('remote_addr', 'chuck-dev');
        $list = $rpc->view(
        	/* string    zone */ 'zone:1', 
        	/* int campaignid */ 0, 
        	/* string  target */ '', 
        	/* string  source */ '', 
        	/* 0|1   withText */ 0, 
        	/* array  contect */ [], 
        	/* strubg charset */ ''
		);
        var_dump(json_decode(json_encode($list),true));
```

