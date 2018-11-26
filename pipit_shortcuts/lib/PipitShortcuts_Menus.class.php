<?php
    
    class PipitShortcuts_Menus extends PerchAPI_Factory
    {
        protected $singular_classname = 'PipitShortcuts_Menu';
        protected $table    = 'pipit_shortcuts_menus';
        protected $pk   = 'menuID';

        
        /**
         * Registers Menus
         * 
         * @param array an array of Menu IDs to register
         */
        function register_menus($menuIDs) {
            foreach($menuIDs as $menuID) {
                if(!$this->find($menuID)) {
                    // doesn't exists
                    $data['menuID'] = $menuID;
                    $this->create($data);
                }
            }
        }




        /**
         * Deletes Menus that are no longer registered.
         * 
         * @param array an array of registered Menu IDs (keep and delete everything else)
         */
        function clean_menus($menuIDs_to_keep) {
            $all_registered_menus = $this->all();
            
            foreach($all_registered_menus as $menu) {
                $ID = $menu->id();

                if(!in_array($ID, $menuIDs_to_keep)) {
                    // doesn't exists
                    $Menu = $this->find($ID);
                    $Menu->delete();
                }
            }
        }





        /**
         * Gets an array of registered menu IDs for the edit form.
         */
        function get_registered_for_form() {
            $sql = 'SELECT menuID FROM ' . $this->table;
            $rows = $this->db->get_rows($sql);
            
            $details = $values = array();
            
            foreach($rows as $row) {
                $values[] = $row['menuID'];
            }

            // edit form requires perfixed key and nude key
            $details['perch_menus'] = $details['menus'] = $values;
            return $details;
        }
    }