<?php
/* =========== function epson_CR ========== */
function espon_CR ($conn) {

  fputs($conn, "\x0d");

  return 1;

}

/* =========== function epson_LF ========== */
function espon_LF ($conn) {

  fputs($conn, "\x0a");
  return 1;

}

/* =========== function epson_LFCR ========== */
function espon_LFCR ($conn) {

  fputs($conn, "\x0a\x0d");
  return 1;

}
/* =========== function epson_text_LFCR ========== */
function espon_text_LFCR ($conn, $text) {

  fputs($conn, $text."\x0a\x0d");
  return 1;

}
?>
