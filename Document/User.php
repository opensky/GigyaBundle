<?php

namespace OpenSky\Bundle\GigyaBundle\Document;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * <provider>facebook</provider>
 * <providerUID>000000</providerUID>
 * <isLoginIdentity>false</isLoginIdentity>
 * <allowsLogin>false</allowsLogin>
 * <nickname>Bobi</nickname>
 * <photoURL>http://profile.ak.facebook.com/v222/15/34/00.jpg</photoURL>
 * <thumbnailURL>http://profile.ak.facebook.com/v222/15/34/q770169391_5172.jpg</thumbnailURL>
 * <firstName>Bobi</firstName>
 * <lastName>A</lastName>
 * <gender>f</gender>
 * <age>37</age>
 * <birthDay>31</birthDay>
 * <birthMonth>5</birthMonth>
 * <birthYear>1972</birthYear>
 * <email>bla@gmail.com</email>
 * <city>Tel Aviv</city>
 * <profileURL>http://www.facebook.com/profile.php?id=00</profileURL>
 * <proxiedEmail/>
 * <isExpiredSession>false</isExpiredSession>
 */
class User implements UserInterface
{
    /**
     * @var string
     */
    private $uid;

    /**
     * @var string
     */
    private $provider;

    /**
     * @var string
     */
    private $nickname;

    /**
     * @var string
     */
    private $photoUrl;

    /**
     * @var string
     */
    private $thimbnailUrl;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var string
     */
    private $age;

    /**
     * @var string
     */
    private $birthday;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $zip;

    /**
     * @var string
     */
    private $profileUrl;

    public function __construct($uid, $provider)
    {
        $this->uid = $uid;
        $this->provider = $provider;
    }

    /**
     * @see Symfony\Component\Security\Core\User\UserInterface::getRoles()
     */
    public function getRoles()
    {
        return array('ROLE_GIGYA');
    }

    /**
     * @see Symfony\Component\Security\Core\User\UserInterface::getPassword()
     */
    public function getPassword()
    {
        return '';
    }

    /**
     * @see Symfony\Component\Security\Core\User\UserInterface::getSalt()
     */
    public function getSalt()
    {
        return '';
    }

    /**
     * @see Symfony\Component\Security\Core\User\UserInterface::getUsername()
     */
    public function getUsername()
    {
        return $this->uid;
    }

    /**
     * @see Symfony\Component\Security\Core\User\UserInterface::eraseCredentials()
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see Symfony\Component\Security\Core\User\UserInterface::equals()
     */
    public function equals(UserInterface $user)
    {
        return $this->uid === $user->getUsername();
    }

    public function getProvider()
    {
        return $this->provider;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    public function getPhotoUrl()
    {
        return $this->photoUrl;
    }

    public function setPhotoUrl($photoUrl)
    {
        $this->photoUrl = $photoUrl;
    }

    public function getThimbnailUrl()
    {
        return $this->thimbnailUrl;
    }

    public function setThimbnailUrl($thimbnailUrl)
    {
        $this->thimbnailUrl = $thimbnailUrl;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getZip()
    {
        return $this->zip;
    }

    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    public function getProfileUrl()
    {
        return $this->profileUrl;
    }

    public function setProfileUrl($profileUrl)
    {
        $this->profileUrl = $profileUrl;
    }
}
