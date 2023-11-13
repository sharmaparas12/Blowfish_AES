<?php

function encryptBlowfish($data, $key)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('bf-cbc'));
    $encryptedData = openssl_encrypt($data, 'bf-cbc', $key, 0, $iv);
    return base64_encode($iv . $encryptedData);
}

function decryptBlowfish($data, $key)
{
    $data = base64_decode($data);
    $ivSize = openssl_cipher_iv_length('bf-cbc');
    $iv = substr($data, 0, $ivSize);
    $encryptedData = substr($data, $ivSize);
    return rtrim(openssl_decrypt($encryptedData, 'bf-cbc', $key, 0, $iv), "\0");
}

$blowfishKey = "129383894833";
$customerVoterID = "123456789";

$encryptedData = encryptBlowfish($customerVoterID, $blowfishKey);
echo "Encrypted Data: " . $encryptedData . "\n";

$decryptedData = decryptBlowfish($encryptedData, $blowfishKey);
echo "Decrypted Data: " . $decryptedData;

?>
