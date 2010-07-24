<?php
/**
 * Plugin Name: Drop Down Links
 * Version: 0.0.1
 * Description: Widget that put all the links in the drop down
 * Author: Z.Muhsin
 * Author URI: http://www.zanbytes.com
 * Plugin URI: http://www.forums.mzalendo.net
 */
add_filter('get_bookmarks', 'dropDownLinks');
//add the javascript
add_action('wp_print_scripts', 'getJavascript'); 

/**
 * Interface to the plugin
 * @return null
 */
function dropDownLinks()
{
    $dropDownObj = new dropDownLinks();
    $linkStr = $dropDownObj->getLinks();
    //return the drop-down
    echo($linkStr);
    
    return null;
}

/**
 * Add plugins javascript that depends on prototype
 * @return true
 */
function getJavascript()
{
    if (function_exists('wp_enqueue_script')) {
        wp_enqueue_script('drop-down-links',plugins_url('drop-down-links/js/drop-down-links.js'), array('prototype'));
    }
    return true;
}

/**
 * drop-down-link class
 */
class dropDownLinks
{
    const HEADING = '<h3>Links</h3>';
    
    public function  __construct()
    {
    }

    /**
     * Get all the links in the wp_links table
     * @return <type> $res array with wp_links
     */
    protected function _getLinksData()
    {
        $query = "SELECT link_url,link_name FROM wp_links";
        $dbuser = DB_USER;
        $wpdb = new wpdb(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
        $res = $wpdb->get_results($query);
        return $res;
    }

    /**
     * Put some js, html etc
     */
    protected function _prepHtmlLinks()
    {
        $links = $this->_getLinksData();
        $linkStr .= __(self::HEADING);
        $linkStr .= '<select id="drop-down-links" size="5" multiple style="width:175px;">';
        foreach ($links as $link) {
            $url = $link->link_url;
            $name = $link->link_name;
            $linkStr .=  "<option value=\"$url\">$name</option>";
        }
         $linkStr .= "</select>";
        return $linkStr;
    }

    /**
     * public interface
     */
    public function getLinks()
    {
        return $this->_prepHtmlLinks();
    }

}


