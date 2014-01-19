<?php

/***************************************************************************
 *
 *   RobotStats
 *
 * Author:   Olivier Duffez, WebRankInfo ( http://www.webrankinfo.com )
 * Version:  1.0
 * Date:     2003-10-11
 * Homepage: http://www.robotstats.com    
 *
 ***************************************************************************/

/***************************************************************************
Basé sur "calendrier" de PHPtools4U.com - Mathieu LESNIAK
email                : support@phptools4u.com
***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/


function afficherCalendrier($robot)
{
  global $PHP_SELF, $RS_LANG, $TAB_MONTHS;

  $m     = getVar("m");
  $rub   = getVar("rub");
  $sens  = getVar("sens");
  $ordre = getVar("ordre");
  $d     = getVar('d');

  if ($m != '')
    $tdClass = "calendarToday";
  else
    $tdClass = "calendarDays";

  $arg_day  = "?rub=".$rub."&amp;robot=".$robot."&amp;d=";
  $arg_week = "?rub=".$rub."&amp;robot=".$robot."&amp;s=";
  $today = time();
  
  if ($d == '')
  {
    $timestamp = $today;
  }
  else
  {
    $month     = substr($d, 4 ,2);
    $day       = substr($d, 6, 2);
    $year      = substr($d, 0 ,4);
    $timestamp = mktime(0, 0, 0, $month, $day, $year);
  }
  
  $current_day      = date("d", $timestamp);
  $current_month    = date('n', $timestamp);
  $current_month_2  = date('m', $timestamp);
  $current_year     = date('Y', $timestamp);
  $first_day_pos    = date("w", mktime(0, 0, 0, $current_month, 1, $current_year));
  $first_day_pos    = ($first_day_pos == 0) ? 7 : $first_day_pos;

  $current_month_name = $TAB_MONTHS[$current_month];
  $nb_days_month    = date("t", $timestamp);
  
  $current_timestamp  = mktime(23,59,59,date("m"), date("d"), date("Y"));
  
  $output = '<TABLE border="0" width="180" class="calendarTable" cellpadding="2" cellspacing="1">'."\n";
  
  ### Displaying the current month/year
  if ($m == '')
  {
  	$month_link = "index.php?rub=".$rub."&amp;robot=".$robot."&amp;d=".$current_year.$current_month_2.$current_day."&amp;s=&amp;m=".$current_month."&amp;ordre=".$ordre."&amp;sens=".$sens;
  	$current_month_link = '<a href="'.$month_link.'" class="calendarTopLink">'.$current_month_name.'</a> '.$current_year."\n";
  }
  else
  {
  	$current_month_link = $current_month_name." ".$current_year;	
  }
  $output .= '<tr>'."\n";
  $output .= '  <td colspan="8" align="center" class="calendarTop">'."\n";
  $output .= $current_month_link;
  $output .= '  </td>'."\n";
  $output .= '</tr>'."\n";
  
  ### Building the table row with the days
  $output .= '<TR align="center">'."\n";
  $output .= '  <td class="calendarHeader">&nbsp;</td>'."\n";
  $output .= '  <td class="calendarHeader"><B>'.$RS_LANG['Monday1']   .'</B></td>'."\n";
  $output .= '  <td class="calendarHeader"><B>'.$RS_LANG['Tuesday1']  .'</B></td>'."\n";
  $output .= '  <td class="calendarHeader"><B>'.$RS_LANG['Wednesday1'].'</B></td>'."\n";
  $output .= '  <td class="calendarHeader"><B>'.$RS_LANG['Thursday1'] .'</B></td>'."\n";
  $output .= '  <td class="calendarHeader"><B>'.$RS_LANG['Friday1']   .'</B></td>'."\n";
  $output .= '  <td class="calendarHeader"><B>'.$RS_LANG['Saturday1'] .'</B></td>'."\n";
  $output .= '  <td class="calendarHeader"><B>'.$RS_LANG['Sunday1']   .'</B></td>'."\n";
  $output .= '</tr>'."\n";  
  
  $output .= '<TR align="center">';
  $int_counter = 0;

  $loop_timestamp = mktime(0,0,0, $current_month, $current_day, $current_year);
  $week = date("W", $loop_timestamp);
  if ( $current_timestamp < $loop_timestamp )
  {
    $output .= '<td class="calendarHeader"><b>'.$week.'</b></td>'."\n";
  }
  else
  {
    $output .= "<td class='calendarHeader'>";
    $output .= "<a href='index.php".$arg_week.$week."&amp;d=".$current_year.$current_month_2.$i_2."' class='calendarTopLink'><b>".$week."</b></A></td>\n";
  }

  // cells before the first day of the month
  for ($i = 1; $i < $first_day_pos; $i++)
  {
    $output .= '<td class="calendarDays">&nbsp;</td>'."\n";
    $int_counter++;
  }

  // Building the table
  for ($i = 1; $i <= $nb_days_month; $i++)
  {
    $i_2 = ($i < 10) ? '0'.$i : $i;   
    
    // Row start
    if ((($i + $first_day_pos-1) % 7) == 1 && $i != 1)
    {
      $output .= '<TR align="center">'."\n";
      $int_counter = 0;
      $loop_timestamp = mktime(0,0,0, $current_month, $i, $current_year);
      $week = date("W", $loop_timestamp);
      
      if ( $current_timestamp < $loop_timestamp )
      {
        $output .= '<td class="calendarHeader"><b>'.$week.'</b></td>'."\n";
      }
      else
      {
        $output .= "<td class='calendarHeader'>";
        $output .= "<a href='index.php".$arg_week.$week."&amp;d=".$current_year.$current_month_2.$i_2."' class='calendarTopLink'><b>".$week."</b></A></td>\n";
      }
    }
    
    if (($i == $current_day) && (getVar("m") == ''))
    {
      $output .= '<td class="calendarToday" align="center">'.$i.'</td>'."\n";
    }
    else
    {
      $loop_timestamp = mktime(0,0,0, $current_month, $i, $current_year);
      
      if ( $current_timestamp < $loop_timestamp )
      {
        $output .= '<td class="calendarDays">'.$i.'</td>'."\n";
      }
      else
      {
        $output .= "<td class='$tdClass'>";
        $output .= "<a href='index.php".$arg_day.$current_year.$current_month_2.$i_2."'>".$i."</A></td>\n";
      }
    }
    $int_counter++;
    
    // Row end
    if ( (($i + $first_day_pos - 1) % 7) == 0 )
    {
      $output .= '</tr>'."\n";  
    }
  }
  $cell_missing = 7 - $int_counter;
  
  for ($i = 0; $i < $cell_missing; $i++)
  {
    $output .= '<td class="calendarDays">&nbsp;</td>'."\n";
  }
  $output .= '</tr>'."\n";

  // Display the nav links on the bottom of the table
  $previous_month = date("Ymd",   
            mktime( 12, 
                0, 
                0, 
                ($current_month - 1),
                $current_day,
                $current_year
                 )
            );
              
  $previous_day   = date("Ymd",   
              mktime( 12, 
                  0, 
                  0, 
                  $current_month,
                  $current_day - 1,
                  $current_year
                   )
              );
  $next_day     = date("Ymd",   
              mktime( 1, 
                  12, 
                  0, 
                  $current_month,
                  $current_day + 1,
                  $current_year
                   )
              );
  $next_month   = date("Ymd",   
              mktime( 1, 
                  12, 
                  0, 
                  $current_month + 1,
                  $current_day,
                  $current_year
                   )
              );

  $g  = '<img src="img/g.gif" border="0" alt="'.$RS_LANG["PreviousDay"].'" />';
  $gg = '<img src="img/gg.gif" border="0" alt="'.$RS_LANG["PreviousMonth"].'" />';
  $d  = '<img src="img/d.gif" border="0" alt="'.$RS_LANG["NextDay"].'" />';
  $dd = '<img src="img/dd.gif" border="0" alt="'.$RS_LANG["NextMonth"].'" />';

  if (( $today < mktime(0,0,0, $current_month, $current_day+1, $current_year)) || (getVar("m") != '') )
  {
    $next_day_link = '&nbsp;';
  }
  else
  {
    $next_day_link = '<a href="index.php?rub='.$rub.'&amp;d='.$next_day.'&amp;robot='.$robot.'">'.$d.'</A>'."\n";
  }

  if ( getVar("m") != '' )
  {
  	$previous_day_link = '&nbsp;';
  }
  else
  {
  	$previous_day_link = '<a href="index.php?rub='.$rub.'&amp;d='.$previous_day.'&amp;robot='.$robot.'">'.$g.'</a>';
  }
  
  if ( $today < mktime(0,0,0, $current_month+1, $current_day, $current_year) )
  {
    $next_month_link = '&nbsp;';    
  }
  else
  {
    $next_month_link  = '<a href="index.php?rub='.$rub.'&amp;d='.$next_month.'&amp;m='.substr($next_month,4,2).'&amp;robot='.$robot.'">'.$dd.'</A>'."\n";
  }
  
  $output .= '<tr>'."\n";
  $output .= '  <td colspan="8" class="calendarDays">'."\n";
  $output .= '    <table width="100%" border="0" >';
  $output .= '    <tr>'."\n";
  $output .= '      <td width="25%" align="left" class="calendarDays">'."\n";
  $output .= '        <b><a href="index.php?rub='.$rub.'&amp;d='.$previous_month.'&amp;m='.substr($previous_month,4,2).'&amp;robot='.$robot.'">'.$gg.'</a></b>'."\n";
  $output .= '      </td>'."\n";
  $output .= '      <td width="25%" align="center" class="calendarDays">'."\n";
  $output .=         $previous_day_link ."\n";
  $output .= '      </td>'."\n";
  $output .= '      <td width="25%" align="center" class="calendarDays">'."\n";
  $output .=          $next_day_link;
  $output .= '      </td>'."\n";
  $output .= '      <td width="25%" align="right" class="calendarDays">'."\n";
  $output .=          $next_month_link;
  $output .= '      </td>'."\n";
  $output .= '    </tr>';
  $output .= '    </table>';
  $output .= '  </td>'."\n";
  $output .= '</tr>'."\n";
    
  $output .= '</table>'."\n";
  
  echo $output;
}
?>