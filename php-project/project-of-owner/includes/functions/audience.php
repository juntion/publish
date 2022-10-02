<?php
/**
 * functions/audience.php
 * Builds output queries for customer segments
 *
 * @package functions
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: audience.php 4135 2006-08-14 04:25:02Z drbyte $
 */

function parsed_query_string($read_string) {
  // extract table names from sql strings, so that prefixes are supported.
  // this will also in the future be used to reconstruct queries from query_keys_list field in query_builder table.

  $allwords = explode( " ", $read_string );
  reset( $allwords );
  while( list( $key, $val ) = each( $allwords ) ) {
    // find "{TABLE_" and extract that tablename
    if( substr( $val, 0, 7) == "{TABLE_"  && substr( $val, -1) == "}" ) { //check for leading and trailing {} braces
      $val = substr( $val, 2, strlen($val)-2);  // strip off braces.  Could also use str_replace(array('{','}'),'',$val);
      //now return the value of the CONSTANT with the name that $val has.  ie: TABLE_CUSTOMERS = zen_customers
      $val = constant($val);
    } elseif ( substr( $val, 0, 6) == "TABLE_" ) {
    //return the value of the CONSTANT with the name that $val has.  ie: TABLE_CUSTOMERS = zen_customers
      $val = constant($val);
    } elseif ( substr( $val, 0, 9) == '$SESSION:' ) {
      //return the value of the SESSION var indicated
      $param = str_replace('$SESSION:', '', $val);
      $val = $_SESSION[$param];
    }
    $good_string .= $val.' ';
   }
   return $good_string;
}

