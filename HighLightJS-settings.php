<?php
if (!function_exists('add_action')){
    exit;
}

function hljs_settings_init(){
    register_setting('hljs-settings', 'hljs-settings');
    add_settings_section(
        'hljs-settings-style-section',
        'Style Settings',
        'hljs_settings_style_section_text',
        'hljs'
    );
    add_settings_field(
        'hljs-settings-style-choose', 
        'Style', 
        'hljs_settings_style_callback', 
        'hljs',
        'hljs-settings-style-section'
    );
}

function hljs_settings_style_section_text() {
    echo '<p>Change the looking of the code highlight.</p>';
}

function hljs_settings_style_callback() {
    $current_style_list=hljs_get_style_css_list();
    echo '<select id="hljs-settings-style-choose" name="hljs-settings[hljs-settings-style-choose]">';
        foreach ($current_style_list as $value) {
            if (get_option('hljs-settings')['hljs-settings-style-choose']==$value) {
                echo '<option value="'.$value.'" selected="selected">';
            } else {
                echo '<option value="'.$value.'">';
            }
            echo $value;
                echo '</option>'."\n";
        }
    echo '</select>';
    //echo "<input name='hljs-settings-style' size='40' type='text' />";
}

function hljs_settings_style_callback_dev(){
    echo 'OK';
}

function hljs_get_style_css_list(){
    $style_dir_list=scandir(plugin_dir_path(__FILE__).'/styles');
    $useless=array(".","..");
    $style_list=array();
    foreach ($style_dir_list as $item) {
        if (!in_array($item,$useless)) {
            if (substr_count($item,'css')!=0) {
                list($style_name, $expand_name) =split('[.]',$item);
                $style_list[]=$style_name;
            }
        }
    }
    return $style_list;
}

function hljs_settings_page(){
    if (!current_user_can('manage_options')){
        return;
    }
    ?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <!--<h3>Current Style List</h3>-->
        <?php
            // $current_style_list=hljs_get_style_css_list();
            // echo "<p>";
            // print_r($current_style_list);
            // echo "</p>";
        ?>
        <form action="options.php" method="post">
            <?php settings_fields('hljs-settings'); ?>
            <?php do_settings_sections('hljs'); ?>
            <!--<input name="Submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save Changes'); ?>"/>-->
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}
add_action('admin_init','hljs_settings_init');
?>