<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://profiles.wordpress.org/iqbal1486/
 * @since      1.0.0
 *
 * @package    Gh_Cf7_Insightly
 * @subpackage Gh_Cf7_Insightly/admin/partials
 */

$active_tab = "";
if(isset($_GET['page']) && $_GET['page'] = "gh-cf-insightly"){
    if(isset($_GET['tab'])){
        $active_tab = $_GET['tab'];
    }else{
        $active_tab = "basic-settings";
    }
}

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<nav class="nav-tab-wrapper">
    <a href="?page=gh-cf-insightly&amp;tab=basic-settings" class="nav-tab <?php if($active_tab == "basic-settings") echo "nav-tab-active"; ?>">Basic Settings</a>
    <a href="?page=gh-cf-insightly&amp;tab=logs" class="nav-tab <?php if($active_tab == "logs") echo "nav-tab-active"; ?>">Logs</a>
    <a href="?page=gh-cf-insightly&amp;tab=mapping" class="nav-tab <?php if($active_tab == "mapping") echo "nav-tab-active"; ?>">Mapping</a>
    <a href="?page=gh-cf-insightly&amp;tab=how-to-use" class="nav-tab <?php if($active_tab == "how-to-use") echo "nav-tab-active"; ?>">How to Use</a>
</nav>

<?php  require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/gh-cf7-insightly-admin-'.$active_tab.'.php'; ?>

