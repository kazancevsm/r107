<?php
   $menutitle  = LAN_C_ROTATOR_GENERAL_1.' '.LAN_C_ROTATOR_MENU_6;
   
   $butname[]  = LAN_C_ROTATOR_GENERAL_3;
   $butlink[]  = "admin_view_entrees.php";
   $butid[]    = "entrees";

   $butname[]  = LAN_C_ROTATOR_GENERAL_4;
   $butlink[]  = "admin_config.php";
   $butid[]    = "config";

   $butname[]  = LAN_C_ROTATOR_GENERAL_5;
   $butlink[]  = "admin_options.php";
   $butid[]    = "preferences";

   global $pageid;
   for ($i=0; $i<count($butname); $i++) {
      $var[$butid[$i]]['text'] = $butname[$i];
      $var[$butid[$i]]['link'] = $butlink[$i];
   };

   show_admin_menu($menutitle, $pageid, $var);
?>