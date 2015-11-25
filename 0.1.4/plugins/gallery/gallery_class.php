<?php
//-----congifuration of gallery
    $mdgal_folder = $pref['mdgal_folder'];
    $mdgal_folder_show_cols = $pref['mdgal_folder_show_cols'];
    $mdgal_pic_show_rows = $pref['mdgal_pic_show_rows'];
    $mdgal_pic_show_cols =$pref['mdgal_pic_show_cols'];
    $mdgal_pic_on_page = $mdgal_pic_show_rows * $mdgal_pic_show_cols;
    $mdgal_pic_icon_height = $pref['mdgal_pic_icon_height'];
    $mdgal_pic_icon_width = $pref['mdgal_pic_icon_width'];
    $mdgal_pic_view_height = $pref['mdgal_pic_view_height'];
    $mdgal_pic_view_width = $pref['mdgal_pic_view_width'];
    $mdgal_title_image = $pref['mdgal_title_image'];
    $mdgal_gallery_name = $pref['mdgal_gallery_name'];
    $mdgal_nav_position = $pref['mdgal_nav_position'];
    $mdgal_menu_caption = $pref['mdgal_menu_caption'];
    $mdgal_menu_pic_size = $pref['mdgal_menu_pic_size'];
    $mdgal_slide_show = $pref['mdgal_slide_show'];
    $mdgal_memo_show = $pref['mdgal_memo_show'];
    $mdgal_mine_cikle = $pref['mdgal_mine_cikle'];
    $mdgal_nav_show = $pref['mdgal_nav_show'];
    $mdgal_comments = $pref['mdgal_comments'];
    $mdgal_raters = $pref['mdgal_raters'];
    $mdgal_hs_theme = $pref['mdgal_hs_theme'];
    $mdgal_pic_quality = $pref['mdgal_pic_quality'];
    $mdgal_sort_type = $pref['mdgal_sort_type'];
    $mg_icon_create = $pref['mg_icon_create'];
    $mg_view_create = $pref['mg_view_create'];
    $mg_minepage_logo = $pref['mg_minepage_logo'];
    $mg_minepage_random = $pref['mg_minepage_random'];
    $mg_minepage_upload = $pref['mg_minepage_upload'];
    $mg_minepage_comment = $pref['mg_minepage_comment'];
    $tn_scr = "foto.php";
    if ($pref['mdgallery_slide_show']) $tn_scr = "tn_foto.php";
    
    $page = $_GET['page'];
    
?>
