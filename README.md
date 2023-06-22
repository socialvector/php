# Social Vector PHP 1.3.9


Social Vector enables developers to easily build social applications and tools to engage websites visitors and customers on a social level that starts off with social sign-in and extends to social sharing, users profiles, friends lists, activities streams, status updates and more.

The main goal of Social Vector is to act as an abstract API between your application and the various social networks APIs and identities providers such as Spaces, Facebook, Twitter and Google.

## Usage

Social Vector provides a number of basic [examples](https://github.com/socialvector/php/tree/master/examples). You can also find complete Social Vector documentation at https://socialvector.github.io

```php
$config = [
    'callback' => 'https://example.com/path/to/script.php',
    'keys' => [
        'key' => 'your-twitter-consumer-key',
        'secret' => 'your-twitter-consumer-secret',
    ],
];

try {
    $twitter = new SocialVector\Provider\Twitter($config);

    $twitter->authenticate();

    $accessToken = $twitter->getAccessToken();
    $userProfile = $twitter->getUserProfile();
    $apiResponse = $twitter->apiRequest('statuses/home_timeline.json');
}
catch (\Exception $e) {
    echo 'Oops, we ran into an issue! ' . $e->getMessage();
}
```

#### Requirements

* PHP 5.4+
* PHP Session
* PHP cURL

#### Installation

To install Social Vector we recommend [Composer](https://getcomposer.org/), the now defacto dependency manager for PHP. Alternatively, you can download and use the latest release available at [GitHub](https://github.com/socialvector/php/releases).

#### Questions, Help and Support?

For general questions (i.e, "how-to" questions), please consider using [StackOverflow](https://stackoverflow.com/questions/tagged/socialvector) instead of the GitHub issues tracker. For convenience, we also have a [low-activity] [Spaces group](https://spacesnet.com/socialvector) if you want to get help directly from the community.

#### License

Social Vector PHP Library is released under the terms of MIT License.

For the full Copyright Notice and Disclaimer, see [COPYING.md](https://github.com/socialvector/php/blob/main/COPYING.md).
