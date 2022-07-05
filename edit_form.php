<?php

class block_studia_news_edit_form extends block_edit_form {

    protected function specific_definition($mform) {
        global $DB;

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Card Group Title Configuration
        $mform->addElement('text', 'config_tag', "Tag Name", 'size=50');
        $mform->setDefault('config_tag', 'pengumuman');
        $mform->setType('config_tag', PARAM_RAW);

        // Card Group Title Configuration
        $mform->addElement('text', 'config_limit', "Number of Announcement", 'type=number');
        $mform->setDefault('config_limit', 2);
        $mform->setType('config_limit', PARAM_INT);
    }
}