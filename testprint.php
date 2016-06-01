<?php

$fp = fsockopen("192.168.1.3", "9100");

if(!$fp){
        $retval = 'error';
        showEcho('error num is ',$errno);
        showEcho('error is ',$errstr);

}else{
/*
  fputs($fp, chr(55));
  fputs($fp, chr(0));
  fputs($fp, chr(27).chr(32).chr(64));
  fputs($fp, chr(27).chr(32).chr(61).chr(32).chr(49));
  fputs($fp, chr(27).chr(32).chr(33).chr(32).chr(48));
  fputs($fp, chr(27).chr(32).chr(97).chr(32).chr(49));
*/
/*  fputs($fp, chr(27).chr(32).chr(77).chr(32).chr(48));*/  /* ESC M 0 */

  fputs($fp, "\x1b\x40 January 14, 2002 15:00");
/*
  fputs($fp, chr(27).chr(32).chr(100).chr(32).chr(49));*/ /* ESC d 1 */
/*  fputs($fp, chr(27).chr(32).chr(97).chr(32).chr(48));*/ /* ESC a 0 */
/*  fputs($fp, chr(0x0A) ); */
  fputs($fp,  "test\xOd");
/*  fputs($fp, chr(10) ); *//* LF */
  fputs($fp,  "test2");
/*  fputs($fp, chr(10) );*/
/*  fputs($fp, chr(0x0A) ); */

fclose ($fp);
}
?>
