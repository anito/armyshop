<?php
//------------------------------------------------------------------------------
if ( !isset ( $_SERVER [ "PHP_SELF" ] ) || basename ( $_SERVER [ "PHP_SELF" ] ) == basename (__FILE__) ) { $error_path = "../../"; include ( "../../func/func_error.php" ); exit; };
//------------------------------------------------------------------------------
if ( $plugin_security == 1 ) // Security Check
 {
  @session_start(); if ( $_SESSION [ "hidden_stat" ] != md5_file ( "config/config.php" ) ) { include ( "func/func_error.php" ); exit; }
 }
################################################################################
### plugin code ###
//------------------------------------------------------------------------------
// Plugin Language Specific
    if ( $language_plugin_select == "de" ) { }
elseif ( $language_plugin_select == "en" ) { }
elseif ( $language_plugin_select == "nl" ) { }
elseif ( $language_plugin_select == "it" ) { }
elseif ( $language_plugin_select == "es" ) { }
elseif ( $language_plugin_select == "fa" ) { }
elseif ( $language_plugin_select == "dk" ) { }
elseif ( $language_plugin_select == "fr" ) { }
elseif ( $language_plugin_select == "tr" ) { }
elseif ( $language_plugin_select == "hu" ) { }
elseif ( $language_plugin_select == "pt" ) { }
elseif ( $language_plugin_select == "he" ) { }
elseif ( $language_plugin_select == "ru" ) { }
elseif ( $language_plugin_select == "rs" ) { }
elseif ( $language_plugin_select == "fi" ) { }
else { }
//------------------------------------------------------------------------------
// Read Logfile
$track_file_names = unserialize ( file_get_contents ( "log/logdb_track_file.dta" ) );
//------------------------------------------------------------------------------
echo '
<script type="text/javascript" src="plugins/onclick/switchcontent.js"></script>
<script type="text/javascript" src="plugins/onclick/switchicon.js">
//
// Switch Content script II (icon based)- (c) Dynamic Drive (www.dynamicdrive.com)
// Requires switchcontent.js and included before this file!
// Visit http://www.dynamicdrive.com/ for full source code
//
</script>
';

echo '
<table id="content" style="width:100%; border-collapse:collapse; border-spacing:0">
<tr>
  <td style="padding:10px 0px 10px 0px; text-align:center; vertical-align:top">'."\n\n";

  if ( $_SESSION [ "loggedin" ] != "user" )
   {
    // last download
    echo $last_click_id." <b>".$track_file_names [ "last-download" ] [ 1 ]."</b> ".$last_click_id_at." ".date ( "d.m.Y - H:i:s" , $track_file_names [ "last-download" ] [ 0 ] )."\n";

    // onclick overview
    $detail = 0;
    echo '<div id="overview" style="margin:auto; margin-top:10px">'."\n";
    echo '<div id="title_1"><b>'.$title_id.'</b></div>'."\n";
    echo '<div id="title_2"><b>'.$title_counts.'</b></div>'."\n";
    echo '<div id="title_3"><b>'.$title_delete.'</b></div>'."\n";
    echo '<div style="clear:left"></div>'."\n";
    foreach ( $track_file_names as $file_name => $data )
     {
      $detail ++;
      foreach ( $data as $key => $value )
       {
        if ( $file_name != "last-download" )
         {
          if ( $key == 0 )
           {
            echo '<div class="id">'.$file_name.'</div>'."\n";
            echo '<div class="clicks"><span id="detail'.$detail.'-title" class="iconspan"><img src="plugins/onclick/minus.gif" title="'.$title_detail.'" alt="'.$title_detail.'"></span>'.$value.'</div>'."\n";
            echo '<div class="delete">'; if ( $_SESSION [ "loggedin" ] == "admin" ) { echo '<a href="plugins/onclick/delete.php?kill_id='.$file_name.'" target="popup_delete" onclick="window.open(this.href,\'popup_delete\',\'toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=100,height=50,left=0,top=0\');return false"><img src="plugins/onclick/delete.gif" width="11" height="16" style="vertical-align:middle; margin-top:-2px; margin-bottom:-1px" alt=""></a>'; } else { echo '<img src="images/pixel.gif" width="11" height="16" style="vertical-align:middle; margin-top:-2px; margin-bottom:-1px" alt="">'; } echo '</div>'."\n";
            echo '<div style="clear:left"></div>'."\n";
           }
          else
           {
            $ausgabe .= $key." - <b>".$value."</b><br>\n";
           }
         }
       }
      if ( $file_name != "last-download" )
       {
        echo '<div id="detail'.$detail.'" class="icongroup">'."\n".'<div style="width:100%; text-align:center"><b>'.$title_detail.'</b></div>'."\n".$ausgabe.'</div>'."\n";
       }
      unset ( $ausgabe );
     }
    echo '</div>'."\n";
   }
  else
   {
    echo $lang_user_txt[1].'<br><br>
    <b>'.$lang_user_txt[2].':</b>
    <form name="admin_status" action="plugins/onclick/change_session.php" method="post" target="popup_admin_status" onsubmit="window.open(this.action,\'popup_admin_status\',\'height=100px,width=100px\')">
    <input type="password" name="password" style="width:150px" value="">
    <input type="hidden" name="language_plugin_select" value="'.$language_plugin_select.'">
    <input type="submit" name="submit" value="OK">
    </form>
    <br>
    <script type="text/javascript">
    <!-- //
		  document.admin_status.password.focus();
    // -->
    </script>
    ';
   }

  echo '
  <br>
  </td>
</tr>
</table>
';

echo '
<script type="text/javascript">
var detail=new switchicon("icongroup", "div") //Limit scanning of switch contents to just "div" elements
detail.setHeader(\'<img src="plugins/onclick/minus.gif" title="'.$title_detail.'" alt="'.$title_detail.'" />\', \'<img src="plugins/onclick/plus.gif" title="'.$title_detail.'" alt="'.$title_detail.'" />\') //set icon HTML
detail.collapsePrevious(true) //Allow only 1 content open at any time
detail.setPersist(false) //No persistence enabled
detail.init()
</script>
';
################################################################################
?>