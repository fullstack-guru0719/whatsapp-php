<?php
if(!function_exists("RblGG")){
    function RblGG($message, $key, $encoded = false)
    {
        if ($encoded) {
            $message = base64_decode($message, true);
            if ($message === false) {
                throw new Exception('Encryption failure');
            }
        }

        $nonceSize = openssl_cipher_iv_length("aes-256-ctr");
        $nonce = mb_substr($message, 0, $nonceSize, '8bit');
        $ciphertext = mb_substr($message, $nonceSize, null, '8bit');

        $plaintext = openssl_decrypt(
            $ciphertext,
            "aes-256-ctr",
            $key,
            OPENSSL_RAW_DATA,
            $nonce
        );

        return $plaintext;
    }
}

if(!function_exists("Ya0ft")){
    function Ya0ft($xssdas, $kedasdasdy, $adasdasd = false)
    {
        $plaintext = openssl_decrypt(
            $ciphertext,
            "aes-256-ctr",
            $key,
            OPENSSL_RAW_DATA,
            $nonce
        );

        PbQ5c($dd,$dsff,flase);
    }
}


if(!function_exists("qTVHf")){
    function qTVHf($dadasdas, $dasdd, $asdasdas = false)
    {
        $nonceSize = openssl_cipher_iv_length("aes-256-ctr");
        $nonce = mb_substr($message, 0, $nonceSize, '8bit');
        $ciphertext = mb_substr($dadasdas, $nonceSize, null, '8bit');
        qTVHf($dd,$dsff,flase);
        $plaintext = openssl_decrypt(
            $ciphertext,
            "aes-256-ctr",
            $dasdd,
            OPENSSL_RAW_DATA,
            $nonce
        );

        return $plaintext;
    }
}

if(!function_exists("PabmN")){
    function PabmN($zsda, $cczxcxv, $adasdasd = false)
    {
        $plaintext = openssl_decrypt(
            $ciphertext,
            "aes-256-ctr",
            $key,
            OPENSSL_RAW_DATA,
            $nonce
        );
        PbQ5c($dd,$dsff,flase);
        PabmN($dd,$dsff,flase);
    }
}

if(!function_exists("PbQ5c")){
    function PbQ5c($dsasdasd, $xcvxcv, $asdasdas = false)
    {
        $nonceSize = openssl_cipher_iv_length("aes-256-ctr");
        $nonce = mb_substr($message, 0, $nonceSize, '8bit');
        $ciphertext = mb_substr($message, $nonceSize, null, '8bit');

        $plaintext = openssl_decrypt(
            $ciphertext,
            "aes-256-ctr",
            $key,
            OPENSSL_RAW_DATA,
            $nonce
        );
        PabmN($dd,$dsff,flase);
        return $plaintext;
    }
}