<?php

namespace OpenSky\Bundle\GigyaBundle\Tests\Socializer;

use OpenSky\Bundle\GigyaBundle\Document\User;

use Buzz\Message\Request;
use Buzz\Message\Response;
use OpenSky\Bundle\GigyaBundle\Socializer\Socializer;
use OpenSky\Bundle\GigyaBundle\Socializer\UserAction;
use OpenSky\Bundle\GigyaBundle\Tests\GigyaTestCase;

class SocializerTest extends GigyaTestCase
{
    private $socializer;
    private $client;
    private $factory;

    public function setUp()
    {
        parent::setUp();
        $this->apiKey     = 'xxxx';
        $this->providers  = array(1, 2, 3);
        $this->client     = $this->getMockClient();
        $this->factory    = $this->getMockMessageFactory();
        $this->socializer = $this->getSocializer($this->client, $this->factory);
    }

    public function testConstructor()
    {
        $this->assertEquals($this->apiKey, $this->socializer->getApiKey());
        $this->assertEquals($this->providers, $this->socializer->getProviders());
    }

    public function testHasSetGetUserActionByKey()
    {
        $key = 'foo';
        $this->assertFalse($this->socializer->hasUserActionByKey($key));

        $userAction = new UserAction();
        $this->socializer->addUserActionByKey($userAction, $key);

        $this->assertTrue($this->socializer->hasUserActionByKey($key));
        $this->assertEquals($userAction, $this->socializer->getUserActionByKey($key));
    }

    public function testLogin()
    {
        $provider = 'twitter';
        $redirect = 'http://shopopensky.com';
        $request  = new Request();
        $response = new Response();

        $this->factory->expects($this->once())
            ->method('getLoginRequest')
            ->with($provider)
            ->will($this->returnValue($request));

        $this->factory->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));

        $this->client->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->assertSame($response, $this->socializer->login($provider, $redirect));
    }

    public function testGetAccessToken()
    {
        $request  = new Request();
        $response = new Response();

        $response->addHeaders(array(
            'Content-Type' => 'application/json'
        ));

        $response->setContent(
'{
    "access_token":"SlAV32hkKG",
    "expires_in":3600
}'
        );

        $this->factory->expects($this->once())
            ->method('getAccessTokenRequest')
            ->will($this->returnValue($request));

        $this->factory->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));

        $this->client->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->assertEquals(array(
            'access_token' => 'SlAV32hkKG',
            'expires_in'   => 3600
        ), $this->socializer->getAccessToken());
    }

    public function testShouldNotAuthorize()
    {
        $request  = new Request();
        $response = new Response();

        $response->addHeaders(array(
            'Content-Type' => 'application/json'
        ));

        $response->setContent(
'{
    "error":500001,
    "error_description":"500001 - Server error"
}'
        );

        $this->factory->expects($this->once())
            ->method('getAccessTokenRequest')
            ->will($this->returnValue($request));

        $this->factory->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));

        $this->client->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->assertNull($this->socializer->getAccessToken());
    }

    public function testGetUserInfo()
    {
        $token    = 'asd3kwe203jsfje349sjuw123499fv9rnfkv9AmsdFngmsfj';
        $request  = new Request();
        $response = new Response();

        $ucProvider   = 'MySpace';
        $provider     = 'myspace';
        $uid          = '000000';
        $nickname     = 'Bobo';
        $thumbnailUrl = 'http://c4.ac-images.myspacecdn.com/images02/11/00000.jpg';
        $gender       = 'm';
        $age          = 47;
        $birthday     = new \DateTime('08-11-1962');
        $country      = 'IL';
        $profileUrl   = 'http://www.myspace.com/00000000';

        $user = new User($uid, $provider);

        $user->setNickname($nickname);
        $user->setThumbnailUrl($thumbnailUrl);
        $user->setGender($gender);
        $user->setAge($age);
        $user->setBirthday($birthday);
        $user->setCountry($country);
        $user->setProfileUrl($profileUrl);

        $response->setContent(
'<?xml version="1.0" encoding="utf-8" ?>
<socialize.getUserInfoResponse xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="urn:com:gigya:api http://socialize.api.gigya.com/schema" xmlns="urn:com:gigya:api">
    <statusCode>200</statusCode>
    <statusReason>OK</statusReason>
    <callId>09e1f4ae35124d03a07761b65cd39ca2</callId>
    <UID>'.$uid.'</UID>
    <isSiteUID>false</isSiteUID>
    <UIDSignature>0000</UIDSignature>
    <signatureTimestamp>2009-06-21 12:07:09</signatureTimestamp>
    <isSiteUser>true</isSiteUser>
    <isConnected>true</isConnected>
    <loginProvider>'.$ucProvider.'</loginProvider>
    <loginProviderUID>iuyq3ieuyh</loginProviderUID>
    <identities>
        <identity>
            <provider>'.$provider.'</provider>
            <providerUID>'.$uid.'</providerUID>
            <isLoginIdentity>true</isLoginIdentity>
            <allowsLogin>true</allowsLogin>
            <nickname>'.$nickname.'</nickname>
            <thumbnailURL>'.$thumbnailUrl.'</thumbnailURL>
            <gender>'.$gender.'</gender>
            <age>'.$age.'</age>
            <birthDay>'.$birthday->format('j').'</birthDay>
            <birthMonth>'.$birthday->format('n').'</birthMonth>
            <birthYear>'.$birthday->format('Y').'</birthYear>
            <country>'.$country.'</country>
            <profileURL>'.$profileUrl.'</profileURL>
            <proxiedEmail />
            <isExpiredSession>false</isExpiredSession>
        </identity>
        <identity>
            <provider>facebook</provider>
            <providerUID>000000</providerUID>
            <isLoginIdentity>false</isLoginIdentity>
            <allowsLogin>false</allowsLogin>
            <nickname>Bobi</nickname>
            <photoURL>http://profile.ak.facebook.com/v222/15/34/00.jpg</photoURL>
            <thumbnailURL>http://profile.ak.facebook.com/v222/15/34/q770169391_5172.jpg</thumbnailURL>
            <firstName>Bobi</firstName>
            <lastName>A</lastName>
            <gender>f</gender>
            <age>37</age>
            <birthDay>31</birthDay>
            <birthMonth>5</birthMonth>
            <birthYear>1972</birthYear>
            <email>bla@gmail.com</email>
            <city>Tel Aviv</city>
            <profileURL>http://www.facebook.com/profile.php?id=00</profileURL>
            <proxiedEmail/>
            <isExpiredSession>false</isExpiredSession>
        </identity>
        <identity>
            <provider>twitter</provider>
            <providerUID>000000</providerUID>
            <isLoginIdentity>false</isLoginIdentity>
            <allowsLogin>true</allowsLogin>
            <nickname>Bobu</nickname>
            <photoURL>http://static.twitter.com/images/default_profile_normal.png</photoURL>
            <firstName>Bobu</firstName>
            <lastName>A</lastName>
            <profileURL>http://twitter.com/shirlyleshed</profileURL>
            <proxiedEmail />
            <isExpiredSession>false</isExpiredSession>
        </identity>
        <identity>
            <provider>yahoo</provider>
            <providerUID>00000</providerUID>
            <isLoginIdentity>false</isLoginIdentity>
            <allowsLogin>true</allowsLogin>
            <nickname>Shirly</nickname>
            <thumbnailURL>http://a323.yahoofs.com/coreid/000.jpg?ciAgMZLB5RbqrC1K</thumbnailURL>
            <gender>f</gender>
            <profileURL>http://profiles.yahoo.com/u/000</profileURL>
            <proxiedEmail />
            <isExpiredSession>false</isExpiredSession>
        </identity>
    </identities>
    <nickname>Bobo</nickname>
    <thumbnailURL>http://c4.ac-images.myspacecdn.com/images02/11/0000.jpg</thumbnailURL>
    <gender>m</gender>
    <age>47</age>
    <birthDay>11</birthDay>
    <birthMonth>8</birthMonth>
    <birthYear>1962</birthYear>
    <country>IL</country>
    <profileURL>http://www.myspace.com/00000000</profileURL>
    <capabilities>Login, Friends, Notifications, Actions, Status</capabilities>
    <proxiedEmail />
</socialize.getUserInfoResponse>'
        );

        $this->factory->expects($this->once())
            ->method('getUserInfoRequest')
            ->with($token)
            ->will($this->returnValue($request));

        $this->factory->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));

        $this->client->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->assertEquals($user, $this->socializer->getUser($token));
    }
}
