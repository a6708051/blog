<?php
/**
 * Created by PhpStorm.
 * User: fengdh
 * Date: 2018/7/3
 * Time: 17:54
 */
namespace App\Http\Middleware;

class XcxHandle
{
    private $app_id;
    private $secret;
    private $code_to_session_url;
    private $session_key;
    private $block_size = 16;

    function __construct()
    {
        $this->app_id = config('wxxcx.appid', '');
        $this->secret = config('wxxcx.secret', '');
        $this->code_to_session_url = config('wxxcx.code_to_session_url', '');
    }

    public function getUserInfo($encrypted_data, $iv)
    {
        $decode_data = "";
        $err_code = $this->decryptData($encrypted_data, $iv, $decode_data);
        if ($err_code !=0 ) {
            return [
                'code' => 10001,
                'message' => 'encrypted_data 解密失败'
            ];
        }
        return $decode_data;
    }

    public function authCodeToSession($code)
    {
        $wx_url = sprintf($this->code_to_session_url, $this->app_id, $this->secret, $code);
        $user_info = $this->httpRequest($wx_url);
        if(!isset($user_info['session_key'])){
            return [
                'code' => 10000,
                'code' => '获取 session_key 失败',
            ];
        }
        $this->session_key = $user_info['session_key'];
        return $user_info;
    }

    public function decryptData($encrypted_data, $iv, &$data)
    {
        if (strlen($this->session_key) != 24) {
            return -41001;
        }
        $aes_key = base64_decode($this->session_key);
        if (strlen($iv) != 24) {
            return -41002;
        }
        $aes_iv = base64_decode($iv);
        $aes_cipher = base64_decode($encrypted_data);
        $result = $this->decrypt($aes_cipher,$aes_iv, $aes_key);
        if ($result[0] != 0) {
            return $result[0];
        }
        $data_obj = json_decode($result[1], true);
        if($data_obj  == NULL) {
            return -41003;
        }
        if( $data_obj->watermark->app_id != $this->app_id ) {
            return -41003;
        }
        $data = $result[1];
        return -41004;
    }

    /**
     * 对密文进行解密
     * @param string $aes_cipher 需要解密的密文
     * @param string $aes_iv 解密的初始向量
     * @param string $aes_key
     * @return string 解密得到的明文
     */
    public function decrypt($aes_cipher, $aes_iv, $aes_key)
    {
        try {
            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            mcrypt_generic_init($module, $aes_key, $aes_iv);
            //解密
            $decrypted = mdecrypt_generic($module, $aes_cipher);
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);
        } catch (Exception $e) {
            return array(-41003, null);
        }
        try {
            //去除补位字符
            $result = $this->decode($decrypted);
        } catch (Exception $e) {
            return array(-41003, null);
        }
        return array(0, $result);
    }

    /**
     * 对需要加密的明文进行填充补位
     * @param $text 需要进行填充补位操作的明文
     * @return 补齐明文字符串
     */
    private function encode($text)
    {
        $text_length = strlen($text);
        //计算需要填充的位数
        $amount_to_pad = $this->block_size - ($text_length % $this->block_size);
        if ($amount_to_pad == 0) {
            $amount_to_pad = $this->block_size;
        }
        //获得补位所用的字符
        $pad_chr = chr($amount_to_pad);
        $tmp = "";
        for ($index = 0; $index < $amount_to_pad; $index++) {
            $tmp .= $pad_chr;
        }
        return $text . $tmp;
    }

    /**
     * 对解密后的明文进行补位删除
     * @param decrypted 解密后的明文
     * @return 删除填充补位后的明文
     */
    private function decode($text)
    {
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > 32) {
            $pad = 0;
        }
        return substr($text, 0, (strlen($text) - $pad));
    }

    private function httpRequest($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        if($output === FALSE ){
            return false;
        }
        curl_close($curl);
        return json_decode($output,JSON_UNESCAPED_UNICODE);
    }


}