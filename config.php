<?PHP
  /**********|| Thumbnail Image Configuration ||***************/
  $config['ThumbnailImageMode']=2;    // show thumbnail image by proxy from this server

  /**********|| Video Download Link Configuration ||***************/
  $config['VideoLinkMode']='both'; // show both direct and by proxy download links

  /**********|| features ||***************/
  $config['feature']['browserExtensions']=true; // show links for install browser extensions? true or false
  
  /**********|| Other ||***************/
  date_default_timezone_set("Asia/Tehran");
  
  // Debug mode
  $debug=false; // debug mode off
  
  //开启自动上传
  define('AUTOUPLOAD', FALSE);
  //开启遮标
  define('AUTODELOGO', TRUE);
  /**********|| Don't edit below ||***************/
  include_once('common.php');
  spl_autoload_register(array('Common', 'autoLoad'));
?>
