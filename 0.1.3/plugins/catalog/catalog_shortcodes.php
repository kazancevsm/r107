<?php
if (!defined('e107_INIT')) { exit; }
include_once(e_HANDLER.'shortcode_handler.php');
$catalog_shortcodes = $tp -> e_sc -> parse_scbatch(__FILE__);

SC_BEGIN LINK_SORTORDER
global $LINK_SORTORDER;
return $LINK_SORTORDER;
SC_END



?>