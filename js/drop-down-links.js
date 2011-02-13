/**
 * Plugin Name: Drop Down Links
 * Description: Widget that put all the links in the drop down
 * Author: Z.Muhsin
 * Author URI: http://www.zanbytes.com
 * Plugin URI:http://wordpress.org/extend/plugins/drop-down-links/
 */
//document.observe('dom:loaded', function() {
//    $('drop-down-links').observe('click', function() {
//        var selectedLink = $('drop-down-links').getValue();
//        if (selectedLink !='null' || selectedLink !='') {
//            window.open(selectedLink, "", "")
//        }
//    })
//});

function dropDownLinks() {
    var selectedLink = document.getElementById('drop-down-links').value;
    if (selectedLink !='null' || selectedLink !='') {
        window.open(selectedLink, "", "")
    }
}
