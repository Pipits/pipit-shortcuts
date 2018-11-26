<?php
return function(){

    $API   = new PerchAPI(1, 'pipit_shortcuts');
    $HTML = $API->get('HTML');
    $Template = $API->get('Template');

    $ShortcutsMenus = new PipitShortcuts_Menus($API);
    $registered_menus = $ShortcutsMenus->all();

    if (PerchUtil::count($registered_menus)==0) {
        // Install
        $ShortcutsMenus->attempt_install();
    }

    if($registered_menus) {
        $MenuItems = new PerchMenuItems;
        $menus_data = array();
    
        foreach($registered_menus as $registered_menu) {
            $Menu = $MenuItems->find($registered_menu->id());
            $menu_content = array();
            $menu_content['heading'] = $Menu->itemTitle();
            $menu_content['_order'] = $Menu->itemOrder();
            $items = $MenuItems->get_for_parent($registered_menu->id());
    
            foreach($items as $item) {
                $menu_content['links'][] = [
                    'title' => $item->itemTitle(),
                    'link' => $item->get_link()
                ];
            }
    
    
            $menus_data[] = $menu_content;
        }
        
        

        usort($menus_data, function ($item1, $item2) {
            return $item1['_order'] <=> $item2['_order'];
        });

        
        $Template->set('shortcuts/dashboard_widget.html', 'content');
        $html = $Template->render_group($menus_data);
        return $html;
    }

    return false;
};