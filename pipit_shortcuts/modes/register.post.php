<?php
    echo $HTML->title_panel([
        'heading' => $Lang->get('Register Menus'),
    ], $CurrentUser);

    if ($message) echo $message;

    
    echo $EditForm->form_start();
        
    echo $HTML->heading2('Menus');
    echo $EditForm->fields_from_template($Template, $details);
    echo $EditForm->submit_field('btnSubmit', 'Save', $return_link);
    
    echo $EditForm->form_end();