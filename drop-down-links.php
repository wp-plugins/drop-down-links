<?php
/**
 * Plugin Name: Drop Down Links
 * Version: 0.0.5
 * Description: Widget that put all the links in the drop down
 * Author: Z.Muhsin
 * Author URI: http://www.zanbytes.com
 * Plugin URI: http://wordpress.org/extend/plugins/drop-down-links/
 */

/**
 * drop-down-link class
 */
class dropDownLinks extends WP_Widget
{
    /**
     * Plugin version
     */
    const PLUGIN_VERSION = '0.0.5';

    /**
     *
     */
    function dropDownLinks()
    {
        parent::WP_Widget(false, $name = 'Drop down links');
        add_action('wp_print_scripts', array($this,'_getJavascript'));
    }
    
    /**
     * @see WP_Widget::widget
     * @param <type> $args
     * @param <type> $instance
     */
    function widget($args, $instance)
    {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }
        echo $this->getLinks();
    }


    /**
     * @see WP_Widget::form
     * @param <type> $instance
     */
    function form($instance)
    {
        $title = esc_attr($instance['title']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>">
            <?php _e('Title:'); ?>
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                           name="<?php echo $this->get_field_name('title'); ?>"
                           type="text" value="<?php echo $title; ?>" />
                </label></p>
        <?php
    }

    /**
     * Add plugins javascript that depends on prototype
     * @return true
     */
    function _getJavascript()
    {
        if (function_exists('wp_enqueue_script') && !is_admin()) {
            wp_enqueue_script('drop-down-links',
                plugins_url('drop-down-links/js/drop-down-links.js')
//                array('prototype'),self::PLUGIN_VERSION
             );
        }
        return true;
    }
    
    /**
     * Get all the links in the wp_links table
     * @return <type> $res array with wp_links
     */
    protected function _getLinksData()
    {
        $query = "SELECT link_url,link_name FROM wp_links";
        $wpdb = new wpdb(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
        $res = $wpdb->get_results($query);
        return $res;
    }


    /**
     * Put some js, html etc
     * @param <type> $size
     * @param <type> $width
     * @return string $linkStr
     */
    protected function _prepHtmlLinks($size = "5", $width = "175")
    {
        $links = $this->_getLinksData();
        $linkStr .= "<select onClick='dropDownLinks()' id=\"drop-down-links\" size=\"$size\" multiple style=\"width:175px;\">";
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
     * @return <type>
     */
    public function getLinks()
    {
        return $this->_prepHtmlLinks();
    }

}

add_action('widgets_init', create_function('', 'return register_widget("dropDownLinks");'));
