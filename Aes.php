<?php

function my_encrypt($ssn_ein, $key) {
    
    $encryption_key = base64_decode($key);
    
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    
    $encrypted = openssl_encrypt($ssn_ein, 'aes-256-cbc', $encryption_key, 0, $iv);
    $encoded_iv = base64_encode($iv);
    $encoded_data = base64_encode($encrypted);
    return $encoded_data . '::' . $encoded_iv;
}

function my_decrypt($ssn_ein, $key) {
    
    $encryption_key = base64_decode($key);
    
    list($encoded_data, $encoded_iv) = explode('::', $ssn_ein, 2);
    $iv = base64_decode($encoded_iv);
    $encrypted_data = base64_decode($encoded_data);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}


$encryption_key = base64_encode(openssl_random_pseudo_bytes(32)); 

$ssn_ein = "123-45-6789";

$encrypted_data = my_encrypt($ssn_ein, $encryption_key);
echo "Encrypted Data: " . $encrypted_data . "\n";

$decrypted_data = my_decrypt($encrypted_data, $encryption_key);
echo "Decrypted Data: " . $decrypted_data . "\n";
?>
