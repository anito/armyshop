<?php @session_start(); if ( $_SESSION [ "hidden_func" ] != md5_file ( "config.php" ) ) { $error_path = "../"; include ( "../func/func_error.php" ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.7.x                                                    #
# File-Release-Date:  13/05/17                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2013 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
include ( "config.php" ); // include path to style
include ( "../".substr ( $language , 0 , strpos ( $language , "." ) )."_admin.php" ); // include language vars
//------------------------------------------------------------------------------
if ( $language == "language/german.php"     ) { $lang = "de";    }
if ( $language == "language/english.php"    ) { $lang = "en";    }
if ( $language == "language/dutch.php"      ) { $lang = "nl";    }
if ( $language == "language/italian.php"    ) { $lang = "it";    }
if ( $language == "language/spanish.php"    ) { $lang = "es";    }
if ( $language == "language/catalan.php"    ) { $lang = "es-ct"; }
if ( $language == "language/farsi.php"      ) { $lang = "fa";    }
if ( $language == "language/danish.php"     ) { $lang = "dk";    }
if ( $language == "language/french.php"     ) { $lang = "fr";    }
if ( $language == "language/turkish.php"    ) { $lang = "tr";    }
if ( $language == "language/hungarian.php"  ) { $lang = "hu";    }
if ( $language == "language/portuguese.php" ) { $lang = "pt";    }
if ( $language == "language/hebrew.php"     ) { $lang = "he";    }
if ( $language == "language/russian.php"    ) { $lang = "ru";    }
if ( $language == "language/serbian.php"    ) { $lang = "rs";    }
if ( $language == "language/finnish.php"    ) { $lang = "fi";    }
//------------------------------------------------------------------------------
if ( isset ( $_GET [ "parameter" ] ) && $_GET [ "parameter" ] == "reload" )
 {
  echo "<script language=\"JavaScript\"> top.location.replace('admin.php?action=backup&lang=".$lang."'); </script>";
  exit;
 }
//------------------------------------------------------------------------------
include ( "../func/html_header.php" ); // include html header
//------------------------------------------------------------------------------
if ( !$_POST [ "backup" ] )
 {
  echo '
  <form style="margin:0px" action="'.$_SERVER [ "PHP_SELF" ].'" method="post">
  <table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" class="th2 bold center" style="height:18px; padding:2px; border-bottom:1px solid #0D638A;">'; if ( $db_active == 1 ) { echo ''.$lang_admin_cfb[1].''; } else { echo ''.$lang_admin_lfb[1].''; } echo '</td>
  </tr>
  <tr>
    <td class="bg2">'; if ( $db_active == 1 ) { echo ''.$lang_admin_cfb[2].''; } else { echo ''.$lang_admin_lfb[2].''; } echo '<br><div class="small">'.$lang_admin_cb[3].'<br><br>'.$lang_admin_cb[4].'</div></td>
    <td class="bg3">
    <input type="radio" name="backup" value="zip" checked>ZIP
    <input type="radio" name="backup" value="copy">COPY
    </td>
  </tr>
  <tr>
    <td colspan="2" class="th2 center" style="height:24px; padding:2px; border-top:1px solid #0D638A;">
    <input type="submit" style="border:1px solid #7F9DB9; color:#000000; font-family:Verdana,Arial,Sans-Serif; font-size:12px; background-color:#FEFEFE; padding: 1px 10px 1px 10px; width:auto; overflow:visible; cursor:pointer;" value="'.$lang_admin_cb[5].'">
    </td>
  </tr>
  </table>
  </form>
  ';
 }
else
 {
  //----------------------------------------------------------------------------
  /* vim: set expandtab sw=4 ts=4 sts=4: */
  /**
   *
   * @version $Id: zip.lib.php 10240 2007-04-01 11:02:46Z cybot_tm $
   */

  /**
   * Zip file creation class.
   * Makes zip files.
   *
   * Based on :
   *
   *  http://www.zend.com/codex.php?id=535&single=1
   *  By Eric Mueller <eric@themepark.com>
   *
   *  http://www.zend.com/codex.php?id=470&single=1
   *  by Denis125 <webmaster@atlant.ru>
   *
   *  a patch from Peter Listiak <mlady@users.sourceforge.net> for last modified
   *  date and time of the compressed file
   *
   * Official ZIP file format: http://www.pkware.com/appnote.txt
   *
   * @access  public
   */
  class zipfile
   {
    var $datasec      = array();
    var $ctrl_dir     = array();
    var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
    var $old_offset   = 0;

    function unix2DosTime($unixtime = 0)
     {
        $timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);

        if ($timearray['year'] < 1980) {
            $timearray['year']    = 1980;
            $timearray['mon']     = 1;
            $timearray['mday']    = 1;
            $timearray['hours']   = 0;
            $timearray['minutes'] = 0;
            $timearray['seconds'] = 0;
        }

        return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) |
                ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
     }

    function addFile($data, $name, $time = 0)
     {
      $name     = str_replace('\\', '/', $name);

      $dtime    = dechex($this->unix2DosTime($time));
      $hexdtime = '\x' . $dtime[6] . $dtime[7]
                . '\x' . $dtime[4] . $dtime[5]
                . '\x' . $dtime[2] . $dtime[3]
                . '\x' . $dtime[0] . $dtime[1];
      eval('$hexdtime = "' . $hexdtime . '";');

      $fr   = "\x50\x4b\x03\x04";
      $fr   .= "\x14\x00";            // ver needed to extract
      $fr   .= "\x00\x00";            // gen purpose bit flag
      $fr   .= "\x08\x00";            // compression method
      $fr   .= $hexdtime;             // last mod time and date

      // "local file header" segment
      $unc_len = strlen($data);
      $crc     = crc32($data);
      $zdata   = gzcompress($data);
      $zdata   = substr(substr($zdata, 0, strlen($zdata) - 4), 2); // fix crc bug
      $c_len   = strlen($zdata);
      $fr      .= pack('V', $crc);             // crc32
      $fr      .= pack('V', $c_len);           // compressed filesize
      $fr      .= pack('V', $unc_len);         // uncompressed filesize
      $fr      .= pack('v', strlen($name));    // length of filename
      $fr      .= pack('v', 0);                // extra field length
      $fr      .= $name;

      $fr .= $zdata;
      $this -> datasec[] = $fr;

      // now add to central directory record
      $cdrec = "\x50\x4b\x01\x02";
      $cdrec .= "\x00\x00";                // version made by
      $cdrec .= "\x14\x00";                // version needed to extract
      $cdrec .= "\x00\x00";                // gen purpose bit flag
      $cdrec .= "\x08\x00";                // compression method
      $cdrec .= $hexdtime;                 // last mod time & date
      $cdrec .= pack('V', $crc);           // crc32
      $cdrec .= pack('V', $c_len);         // compressed filesize
      $cdrec .= pack('V', $unc_len);       // uncompressed filesize
      $cdrec .= pack('v', strlen($name)); // length of filename
      $cdrec .= pack('v', 0);             // extra field length
      $cdrec .= pack('v', 0);             // file comment length
      $cdrec .= pack('v', 0);             // disk number start
      $cdrec .= pack('v', 0);             // internal file attributes
      $cdrec .= pack('V', 32);            // external file attributes - 'archive' bit set

      $cdrec .= pack('V', $this -> old_offset); // relative offset of local header
      $this -> old_offset += strlen($fr);

      $cdrec .= $name;

      // optional extra field, file comment goes here
      // save to central directory
      $this -> ctrl_dir[] = $cdrec;
     }

    function file()
     {
      $data    = implode('', $this -> datasec);
      $ctrldir = implode('', $this -> ctrl_dir);

      return
          $data .
          $ctrldir .
          $this -> eof_ctrl_dir .
          pack('v', sizeof($this -> ctrl_dir)) .  // total # of entries "on this disk"
          pack('v', sizeof($this -> ctrl_dir)) .  // total # of entries overall
          pack('V', strlen($ctrldir)) .           // size of central dir
          pack('V', strlen($data)) .              // offset to start of central dir
          "\x00\x00";                             // .zip file comment length
     }
    //----------------------------------------------------------------------------
   }
  //------------------------------------------------------------------------------
  ini_set ( "memory_limit" , "100M" );
  //$memory_limit = ini_get ( "memory_limit" );
  //$memory_limit = substr ( $memory_limit , 0 , strlen ( $memory_limit ) - 1 );
  //$logfile_size = (int) round ( filesize ( "../log/logdb_backup.dta" ) / 1048576 );
  //------------------------------------
  if ( $db_active == 1 )
   {
    $filename_add = array (
                            "pattern_site_name.inc" ,
                            "pattern_string_replace.inc" ,
                            "../log/cache_time_stamp.php" ,
                            "../log/cache_visitors.php" ,
                            "../log/cache_visitors_counter.php" ,
                            "../log/last_logins.dta" ,
                            "../log/last_timestamp.dta" ,
                            "../log/timestamp_cache_update.dta"
                          );
   }
  else
   {
    $filename_add = array (
                            "./pattern_site_name.inc" ,
                            "./pattern_string_replace.inc" ,
                            "../log/cache_time_stamp.php" ,
                            "../log/cache_visitors.php" ,
                            "../log/cache_visitors_counter.php" ,
                            "../log/index_days.php" ,
                            "../log/last_logins.dta" ,
                            "../log/last_timestamp.dta" ,
                            "../log/logdb.dta" ,
                            "../log/logdb_backup.dta" ,
                            "../log/logdb_track_file.dta" ,
                            "../log/pattern_browser.dta" ,
                            "../log/pattern_operating_system.dta" ,
                            "../log/pattern_referer.dta" ,
                            "../log/pattern_resolution.dta" ,
                            "../log/pattern_site_name.dta" ,
                            "../log/timestamp_cache_update.dta"
                          );
   }
  //------------------------------------
  if ( $_POST [ "backup" ] == "zip" )
   {
    //------------------------------------
    $zipfile = new zipfile();
    $zipfile_filename = "../backup/backup_".date ( "Y-m-d" ).".zip";
	  //------------------------------------
	  foreach ( $filename_add as $filename )
	   {
	    //------------------------------------
	    $clearfilename = substr ( $filename , strrpos ( $filename , "/" ) + 1 );

	    $handle = fopen ( $filename , "r" );
	     $content = fread ( $handle , filesize ( $filename ) );
	    fclose ( $handle );

	    $zipfile->addFile ( $content , $clearfilename , filemtime ( $filename ) );
	    //------------------------------------
	   }
	  //------------------------------------
	  // write the zipfile to the folder
	  $handle = fopen ( $zipfile_filename , "w" );
	   fwrite ( $handle , $zipfile->file() );
	  fclose ( $handle );
	  //------------------------------------
	  echo "<br><br><center><img src=\"../images/admin/done.png\" border=\"0\" width=\"32\" height=\"32\" style=\"vertical-align:middle;\" alt=\"\"> &nbsp; <b>".$lang_admin_cb[6]."</b></center>";
	  echo "<meta http-equiv=\"refresh\" content=\"2; URL=backup.php?parameter=reload\">";
	  //------------------------------------
	 }
	else
	 {
	  //------------------------------------
	  @mkdir ( "../backup/backup_".date ( "Y-m-d" ) );
	  //------------------------------------
	  foreach ( $filename_add as $filename )
	   {
	    //------------------------------------
	    $clearfilename = substr ( $filename , strrpos ( $filename , "/" ) + 1 );
	    copy ( $filename , "../backup/backup_".date ( "Y-m-d" )."/".$clearfilename );
	    //------------------------------------
	   }
	  //------------------------------------
	  echo "<br><br><center><img src=\"../images/admin/done.png\" border=\"0\" width=\"32\" height=\"32\" style=\"vertical-align:middle;\" alt=\"\"> &nbsp; <b>".$lang_admin_cb[6]."</b></center>";
	  echo "<meta http-equiv=\"refresh\" content=\"2; URL=backup.php?parameter=reload\">";
    //------------------------------------
	 }
 }
//------------------------------------------------------------------------------
include ( "../func/html_footer.php" ); // include html footer
//------------------------------------------------------------------------------
?>