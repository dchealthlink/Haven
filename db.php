<?php

function encryptData($data, $p) {
  $iIV = mcrypt_create_iv (mcrypt_get_iv_size (MCRYPT_RIJNDAEL_256,MCRYPT_MODE_ECB), MCRYPT_RAND);
  $sEncrypted = mcrypt_encrypt (MCRYPT_RIJNDAEL_256, $p, $data, MCRYPT_MODE_ECB, $iIV);
  return(base64_encode($sEncrypted));
} 
