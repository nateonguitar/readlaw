<?php
/*
Plugin Name: Pods UI Demo
Plugin URI: http://ui.podscms.org/
Description: An example plugin using Pods and the Pods UI plugins. It adds three new Pods: Gadgets, Foo Bars, and LOLCats. Use this as an example of how you can use the Pods UI. Documentation for Pods UI can be found in your /wp-content/plugins/pods-ui/pods.ui.php file, just below the top. Do not test with /pods-ui/demo.php as it will be replaced when you upgrade Pods UI to newer versions. ALWAYS store your plugins in your own /wp-content/plugins/ folder, outside of the Pods UI folder.
Version: 0.7.3.1
Author: The Pods CMS Team
Author URI: http://podscms.org/
*/

add_action('admin_menu','pods_ui_demo_menu');

function pods_ui_demo_menu()
{
    // See http://codex.wordpress.org/Adding_Administration_Menus for more information about Adding Administration Menus like below
    $icon = ''; // you can use a custom icon! see below
    // $icon = WP_PLUGIN_URL.'/your-plugin-folder/icon.png';
    // add_object_page('Name of Menu', 'Name of Menu', 'Capability', 'Menu Identifier', 'Function Name (not applicable to the example below)', 'Icon URL');
    add_object_page('Pods UI Demo', 'Pods UI Demo', 'read', 'pods-ui-demo', '', $icon);
    // add_submenu_page('Menu Identifier from Above', 'Name of Sub Menu Item', 'Name of Sub Menu Item', 'Capability', 'Sub Menu Identifier (first item should be same as Menu Identifier)', 'Function Name to run on page');
    add_submenu_page('pods-ui-demo', 'Gadgets', 'Gadgets', 'read', 'pods-ui-demo', 'pods_ui_demo_page');
    add_submenu_page('pods-ui-demo', 'Foo Bars', 'Foo Bars', 'read', 'pods-ui-demo-page-two', 'pods_ui_demo_page_two');
    add_submenu_page('pods-ui-demo', 'LOLCats', 'LOLCats', 'read', 'pods-ui-demo-page-three', 'pods_ui_demo_page_three');
    // OR you can use the format in the example below for a single-item Top Level menu (with no sub menu items)
    // add_object_page('LOLCats', 'LOLCats', 'read', 'pods-ui-demo-page-three', 'pods_ui_demo_page_three', $icon);
}

function pods_ui_demo_page()
{
    pods_ui_demo_validate_plugins();
    $object = new Pod('pods_ui_gadget');
    $add_fields = $edit_fields = array('name','information','related_gadget','approved');
    $object->ui = array('title'=>'Gadgets','item'=>'Gadget','columns'=>array('name'=>'Name','approved'=>array('coltype'=>'boolean','label'=>'Approved'),'created'=>'Date Created','modified'=>'Last Modified'),'add_fields'=>$add_fields,'edit_fields'=>$edit_fields,'filters'=>'related_gadget');
    pods_ui_manage($object);
    /*
    // or you can pass as an array, if you want something simple!
    pods_ui_manage(array('pod'=>'pods_ui_gadget',
                                                 'title'=>'Gadgets',
                                                 'item'=>'Gadget',
                                                 'columns'=>array('name'=>'Name',
                                                                                'approved'=>array('coltype'=>'boolean',
                                                                                                                'label'=>'Approved'
                                                                                                                ),
                                                                                'created'=>'Date Created',
                                                                                'modified'=>'Last Modified'
                                                                                ),
                                                 'add_fields'=>array('name',
                                                                                     'information'
                                                                                    ),
                                                 'edit_fields'=>array('name',
                                                                                    'information',
                                                                                    'approved'
                                                                                    ),
                                                 'filters'=>'related_gadget'
                                                 )
                                        );
    */
}

function pods_ui_demo_page_two()
{
    pods_ui_demo_validate_plugins();
    $object = new Pod('pods_ui_foo_bar');
    $add_fields = $edit_fields = array('name','foo','thebar'=>array('hidden'=>true,'default'=>'fooooo'));
    $object->ui = array('title'=>'Foo Bars','item'=>'Foo Bar','sort'=>'t.weight,t.name','reorder'=>'weight','columns'=>array('name'=>'Name','thebar'=>'Bar','created'=>'Date Created','modified'=>'Last Modified'),'add_fields'=>$add_fields,'edit_fields'=>$edit_fields);
    pods_ui_manage($object);
}

function pods_ui_demo_page_three()
{
    pods_ui_demo_validate_plugins();
    $object = new Pod('pods_ui_lolcats');
    $add_fields = $edit_fields = array('name','description','link');
    $object->ui = array('title'=>'LOLCats','item'=>'LOLCat','columns'=>array('name'=>'Name','created'=>'Date Created','modified'=>'Last Modified'),'add_fields'=>$add_fields,'edit_fields'=>$edit_fields);
    pods_ui_manage($object);
}

function pods_ui_demo_validate_plugins($soft=false)
{
    $missing = array();
    if(!is_plugin_active('pods/init.php'))
        $missing[] = 'Pods';
    if(!is_plugin_active('pods-ui/pods-ui.php'))
        $missing[] = 'Pods UI';
    if(!empty($missing))
    {
        $msg = '<strong>Fatal Error:</strong> Missing required plugin(s): '.@implode(',',$missing);
        if($soft)
        {
            echo $msg;
            return false;
        }
        else
            die($msg);
    }
    return true;
}

add_action('admin_init','pods_ui_demo_init');

function pods_ui_demo_init()
{
    $installed = get_option('pods_ui_demo');
    if(empty($installed))
    {
        $check = pods_ui_demo_validate_plugins(true);
        if(!$check)
            return false;
        // Activate the Pods UI Demo package, this is an export of the Pods,
        // and whatever else you may need for the plugin. Not every plugin
        // needs this, you can remove this function.
        $api = new PodAPI();
        // check for one of the pods in the package to ensure we're not attempting to overwrite
        $check = 'pods_ui_foo_bar';
        $result = pod_query("SELECT * FROM @wp_pod_types WHERE name='$check' LIMIT 1");
        $exists = mysql_fetch_assoc($result);
        if(is_array($exists)&&!empty($exists))
        {
            delete_option('pods_ui_demo');
            update_option('pods_ui_demo','1');
            return true;
        }
        $package = file_get_contents(dirname(__FILE__).'/package.txt');
        $package = addslashes(trim($package));
        $validate = $api->validate_package($package);
        if(!is_bool($validate))
        {
            pods_ui_message('Package failed validation: '.$validate,2);
            return false;
        }
        $imported = $api->import_package($package);
        delete_option('pods_ui_demo');
        update_option('pods_ui_demo',($imported===true?'1':'0'));
        return ($imported===true?true:false);
    }
    return true;
}