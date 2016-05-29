<?php

namespace PHPixie\Social\Providers\Facebook;

class Provider extends \PHPixie\Social\OAuth\OAuth2\Provider
{
    protected $loginDataEndpoint = 'me';

    protected function endpointUrl($endpoint)
    {
        $version = $this->configData->get('apiVersion', '2.3');
        return 'https://graph.facebook.com/v'.$version.'/'.$endpoint;
    }

    public function loginUrl($callbackUrl, $additionalPermissions = array())
    {
        $permissions = array_merge(
            $this->configData->get('permissions', array()),
            $additionalPermissions
        );

        return $this->buildLoginUrl(
            'https://www.facebook.com/dialog/oauth',
            $callbackUrl,
            array('permissions' => $permissions)
        );
    }

    protected function getTokenResponse($callbackData, $baseParameters)
    {
        return $this->http()->call(
            'GET',
            $this->endpointUrl('oauth/access_token'),
            $baseParameters
        );
    }

    public function type()
    {
        return 'facebook';
    }
}