<?php

define('SYSTEM_SITE_URL','http://evolution_aob/');
define('ADMIN_SYSTEM_SITE_URL','http://evolution_aob/admin/');
define('SYSTEM_SITE_HOST',$_SERVER['DOCUMENT_ROOT']);
define('APLICATION_NAME','The Google Drive');
define('OWNER_NAME','SkyPearl iNfotech');
define('SUPPORT_APLICATION_EMAIL','support@gdrive.com');
define('ROOT_PATH','/');



// TABLE
define('ADMINUSER_TABLE','adminusers');
define('CUSTOMER_TABLE','users');
define('FOLDER_TABLE','folders');
define('FIX_FOLDER_TABLE','fixfolders');
define('FIX_FILE_TABLE','fixfolderfiles');
define('FILE_TABLE','files');
define('TEAM_TABLE','teams');
define('TEAM_MEMBER_TABLE','team_members');
define('CHAT_TABLE','chats');
define('SHARE_TABLE','sharing');
define('NOTIFICATION_TABLE','notifications');
define('HR_FOLDER_TABLE','hr_folders');
define('HR_FOLDER_LINKS','hr_folder_links');
define('HR_FOLDER_FILES','hr_folder_files');
define('LINK_EXPIRED_LIMIT',24);

$valid_ext = array('pdf','doc','docx','rtf','tex','txt','xls','xlsm','xlsx','rar','zip','ai','bmp','gif','ico','jpeg','jpg','png','ps','psd','svg','tif','tiff','aif','cda','mid','midi','mp3','mpa','wav','wma','wpl','3g2','3gp','avi','flv','h264','m4v','mkv','mov','mp4','mpg','mpeg','rm','swf','vob','wmv','webm');
$video_valid_ext = array('3g2','3gp','avi','flv','h264','m4v','mkv','mov','mp4','mpg','mpeg','rm','swf','vob','wmv','webm');
$audio_valid_ext = array('aif','cda','mid','midi','mp3','mpa','wav','wma','wpl');
$image_valid_ext = array('ai','bmp','gif','ico','jpeg','jpg','png','ps','psd','svg','tif','tiff');
$doc_valid_ext = array('pdf','doc','docx','rtf','tex','txt','xls','xlsm','xlsx','rar','zip');

$media_valid_ext  = array_merge($audio_valid_ext,$video_valid_ext);

define('VALID_EXT',$valid_ext);
define('VIDEO_VALID_EXT',$video_valid_ext);
define('AUDIO_VALID_EXT',$audio_valid_ext);
define('IMAGE_VALID_EXT',$image_valid_ext);
define('MEDIA_VALID_EXT',$media_valid_ext);
define('DOC_VALID_EXT',$doc_valid_ext);
?>