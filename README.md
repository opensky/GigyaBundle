# GigyaBundle

The GigyaBundle adds the ability to add various Gigya related services
to your application. The first service included is the Share Plugin.

## Installation

### Initialize Submodule

    git submodule add git@github.com:antimattr/GigyaBundle.git src/AntiMattr/GigyaBundle

### Application Kernel

Add GoogleBundle to the `registerBundles()` method of your application kernel:

    public function registerBundles()
    {
        return array(
            new AntiMattr\GigyaBundle\GigyaBundle(),
        );
    }

## Configuration

### Socialize and Share

#### Application config.yml

Enable loading of the Share service by adding the following to
the application's `config.yml` file:

    gigya:
        socializer:
            api_key: xxxxxx
            namespace: MyJavaScriptCompatibleVariableNameWithNoSpaces

#### Controller

    use AntiMattr\GigyaBundle\Socializer\ActionLink;
    use AntiMattr\GigyaBundle\Socializer\UserAction;
    use AntiMattr\GigyaBundle\Socializer\Video;


    $socializer = $this->container->get('gigya.socializer');

    $userAction = new UserAction();
    $userAction->setUserMessage('Your comment here...');
    $userAction->setTitle('HOME movie (English with subtitles)');
    $userAction->setDescription('We are living in exceptional times.');
    $userAction->setLinkBack('http://www.youtube.com/watch?v=jqxENMKaeCU');

    $actionLink = new ActionLink(
        'Watch the movie',
        'http://www.youtube.com/watch?v=jqxENMKaeCU&feature=channel_page'
    );

    $userAction->addActionLink($actionLink);

    $video = new Video(
        'http://www.youtube.com/watch?v=G8IozVfph7I&feature=channel_page',
        'http://i4.ytimg.com/vi/G8IozVfph7I/default.jpg'
    );

    $userAction->addMediaItem($video);

    $socializer->addUserActionByKey($userAction, 'my_test_key');

#### View

Include the Gigya source template in the `head` tag of your layout or directly before the closing `</body>` tag (this implementation supports lazy loading).

With twig:

    <div>
        {% include "GigyaBundle:Socializer:share.html.twig" with {
            'userActionKey' : 'my_test_key',
            'enabledProviders' : 'facebook,twitter,yahoo,messenger,google,linkedin',
            'operationMode' : 'multiSelect',
            'snapToElementID' : 'btnShare',
            'onError': null,
            'onSendDone': null,
            'context': null,
            'showMoreButton' : 'false',
            'showEmailButton' : 'false'
        }
        %}
        <input type=button id="btnShare" onclick="javascript:{{ gigya_socializer.getShareFunctionName('my_test_key') }}('simpleShare')" value="Simple Share" />
    </div>
