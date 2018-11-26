<?php
    $API  = new PerchAPI(1.0, 'pipit_shortcuts');

    $MenuItems = new PerchMenuItems;
    $top_level_menus = $MenuItems->get_top_level();

    $ShortcutsMenus = new PipitShortcuts_Menus($API);
    $registered_menus = $ShortcutsMenus->all();
    
    if (PerchUtil::count($registered_menus)==0) {
        // Install
        $ShortcutsMenus->attempt_install();
    }
    

    $message = false;
    $details = $ShortcutsMenus->get_registered_for_form();
    $return_link = $API->app_path();

    $Template = $API->get('Template');
    $Template->set('shortcuts/register.html', 'content');

    $EditForm = $API->get('Form');
    $EditForm->set_name('edit');
    $EditForm->handle_empty_block_generation($Template);
    $EditForm->set_required_fields_from_template($Template, $details);


    if ($EditForm->submitted()) {
        $dynamic_fields = $EditForm->receive_from_template_fields($Template, false, false, false, true, false);

        if($dynamic_fields && isset($dynamic_fields['menus'])) {
            $ShortcutsMenus->register_menus($dynamic_fields['menus']);
            $ShortcutsMenus->clean_menus($dynamic_fields['menus']);
        } else {
            $ShortcutsMenus->clean_menus([]);
        }

        $details = $ShortcutsMenus->get_registered_for_form();
    } 