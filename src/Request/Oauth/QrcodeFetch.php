<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/23 下午3:39
 */

namespace eDoctor\Phpecs\Request\Oauth;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class QrcodeFetch extends PhpecsRequest
{
    private $api = 'oauth/v1/qrcode/fetch';

    private $prefix;
    private $platform;
    private $roleOptions;

    public function setPrefix($val)
    {
        $this->prefix = (string) $val;
    }

    public function setPlatform($val)
    {
        $this->platform = (string) $val;
    }

    public function setRoleOption($val)
    {
        $this->roleOptions = (array) $val;
    }

    public function getResponse()
    {
        if (Valid::isPlatform($this->platform) === false) {
            throw new PhpecsException('终端类型未设置或者格式错误');
        }
        $roleOptions = (array) $this->roleOptions;
        foreach ($roleOptions as $index => $roleOption) {
            if (Valid::isRole($index)) {
                throw new PhpecsException('角色编号未设置或者存在无效值');
            }
        }

        return $this->client->request($this->api, [
            'prefix' => $this->prefix,
            'platform' => $this->platform,
            'role_options' => json_encode($roleOptions),
        ]);
    }
}