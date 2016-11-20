<?php
//-------------------------------------------------
function google_charts ( &$value_array )
 {
  //-------------------------------------------------
  $base_code = '<img src="http://chart.apis.google.com/chart?cht=lc&chco=224499&chs=900x300&chd=s:';
  $x_axis_code = '&chxt=x,y&chxl=0:|';
  #$y_axis_code =  '1:||'.min ( $value_array ).'||'.(int) round ( max ( $value_array ) / 2 ).'||'.max ( $value_array ).'&chm=B,76A4FB,0,0,0">';
  #$y_axis_code =  '1:||'.min ( $value_array ).'||'.(int) round ( max ( $value_array ) / 2 ).'||'.max ( $value_array ).'">';
  #$y_axis_code =  '1:||'.min ( $value_array ).'||'.(int) round ( max ( $value_array ) / 2 ).'||'.max ( $value_array ).'&chls=4.0,3.0,0.0&chg=20,50">';
  $y_axis_code =  '1:||'.min ( $value_array ).'||'.(int) round ( max ( $value_array ) / 2 ).'||'.max ( $value_array ).'&chls=4.0,3.0,0.0&chf=c,lg,0,76A4FB,1,ffffff,0|bg,s,C7C8CB&chg=20,50">';
  //-------------------------------------------------
  $chars      = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  $size_chars = strlen ( $chars );
  //-------------------------------------------------
  echo $base_code;
  //-------------------------------------------------
  foreach ( $value_array as $value )
   {
    //-----------------------------------
    $value = round ( $value / max ( $value_array ) * ( $size_chars - 1 ) );
    echo $chars [ $value ];
    //-----------------------------------
   }
  //-------------------------------------------------
  echo $x_axis_code;
  //-------------------------------------------------
  foreach ( $value_array as $key => $value )
   {
    //-----------------------------------
    echo "|";
    //-----------------------------------
   }
  //-------------------------------------------------
  echo $y_axis_code;
  //-------------------------------------------------
 }
//-------------------------------------------------
?>