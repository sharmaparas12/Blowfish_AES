<?php

function my_encrypt($data, $key)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $encryptedData);
}

function my_decrypt($data, $key)
{
    $data = base64_decode($data);
    $ivSize = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($data, 0, $ivSize);
    $encryptedData = substr($data, $ivSize);
    return rtrim(openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv), "\0");
}

$aesKey = base64_encode(openssl_random_pseudo_bytes(32));
$voterId = "123-45-6789";

$encryptedData = my_encrypt($ssn_ein, $aesKey);
echo "Encrypted Data: " . $encryptedData . "\n";

$decryptedData = my_decrypt($encryptedData, $aesKey);
echo "Decrypted Data: " . $decryptedData . "\n";

?>
