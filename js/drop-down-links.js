/**
 * Plugin Name: Drop Down Links
 * Version: 0.0.1
 * Description: Widget that put all the links in the drop down
 * Author: Z.Muhsin
 * Author URI: http://www.zanbytes.com
 * Plugin URI: http://www.forums.mzalendo.net
 */
document.observe('dom:loaded', function() {
    $('drop-down-links').observe('click', function() {
        var selectedLink = $('drop-down-links').getValue();
        if (selectedLink !='null' || selectedLink !='') {
            window.open(selectedLink, "", "")
        }
    })
});
