<?php if (realpath(@$_SERVER['SCRIPT_FILENAME']) == realpath(__FILE__)) exit("Access Denied"); 
?>
<?php
/**
* Plugin Name: AddThisChina
* Plugin URI: http://addthis.org.cn
* Description: 适合中文网站的AddThis按钮，含有主流中文收藏分享按钮。【<a href="options-general.php?page=addthischina/addthis_admin.php">设置</a>】
* Version: 1.1
*
* Author: 高飞
* Author URI: http://addthis.org.cn
*/


if ( !defined('WP_CONTENT_URL') ) 
    define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content'); 
if ( !defined('WP_CONTENT_DIR') ) 
    define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' ); 
// Guess the location 
$addthis_plugin_path = WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__)); 
$addthis_plugin_url = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)); 
//$addthis_plugin_url = WP_CONTENT_URL.'/plugins/addthischina';

add_option("addthis_show", array("home", "page", "category", "archive", "search"));
add_option("addthis_code", "<span class='addthis_org_cn'><a href='http://addthis.org.cn/share/' title='收藏-分享'><img src='". $addthis_plugin_url ."/a1.gif' alt='' align='absmiddle' /></a></span>");

$addthis_show = get_option("addthis_show");
$addthis_code = get_option("addthis_code");

add_action('admin_menu', 'addthis_admin_menu'); //增加管理导航
//add_action('wp_footer', 'addthis_wp_footer');
add_filter('the_content', 'addthis_the_content');
	

function addthis_the_content($content) {
    global $addthis_show, $addthis_code, $addthis_plugin_url;

    if ((is_home() && !addthis_checked_place("home")) || 
        (is_page() && !addthis_checked_place("page")) || 
        (is_category() && !addthis_checked_place("category")) || 
        (is_archive() && !addthis_checked_place("archive")) || 
        (is_feed() && !addthis_checked_place("feed")) || 
        (is_search() && !addthis_checked_place("search"))) {
        return $content;
    }

    $addthis_u = get_permalink();
	$addthis_t = get_the_title();
	$addthis_d = has_excerpt() ? get_the_excerpt() : "";
	$addthis_tag = addthis_get_tags();
	$addthis_codeHtml = '<script type="text/javascript" src="http://china-addthis.googlecode.com/svn/trunk/addthis.js" charset="utf-8"></script>'. $addthis_code;
	$addthis_codeHtml = preg_replace("/(<span class=\'addthis_org_cn\'><a)/i", "$1 u='".htmlspecialchars($addthis_u)."' t='".htmlspecialchars($addthis_t)."' d='".htmlspecialchars(substr($addthis_d,0,60))."' tag='".htmlspecialchars($addthis_tag)."'", $addthis_codeHtml);

    $content .= "\n" . $addthis_codeHtml;
    return $content;
}

function addthis_admin_menu() {
    add_options_page('分享家：AddThis中文按钮', '分享家AddThis', 10, __FILE__, 'addthis_admin');
	//调用管理页面dd_options_page(page_title, menu_title, access_level/capability, file, [function]);
}

function addthis_admin() {
    global $addthis_show, $addthis_code, $addthis_plugin_url;

    require_once(dirname(__FILE__) . "/addthis_admin.php");
}

function addthis_checked_place($place, $check = false) {
    global $addthis_show;

    $r = is_array($addthis_show) && in_array($place, $addthis_show);
    if ($check && $r) echo " checked=\"checked\"";

    return $r;
}




function addthis_get_tags() {
    $tags = get_the_tags();
    $arr = array();
    if (is_array($tags)) {
    	foreach ($tags as $tag) {
    		$arr[] = $tag->name;
    	}
    }
    return implode(",", $arr);
}
?>