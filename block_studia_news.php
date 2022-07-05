<?php

class block_studia_news extends block_base
{
    public function init()
    {
        $this->title = "Studia News";

    }

    public function get_pages($limit=2, $tag='pengumuman')
    {
        global $DB;
        return $DB->get_records_sql("SELECT D.id,
                                            C.id instance_id,
                                            D.name,
                                            D.intro,
                                            FROM_UNIXTIME(D.timemodified, '%d %M %Y %h:%i') datetime,
                                            (UNIX_TIMESTAMP() - D.timemodified) < 604800 is_new
                                    FROM {tag}  A
                                    JOIN {tag_instance} B ON A.id = B.tagid
                                    JOIN {course_modules} C ON B.itemid = C.id
                                    JOIN {page} D ON C.instance = D.id
                                    WHERE A.name = '$tag'
                                    AND C.visible = 1
                                    ORDER BY D.id DESC
                                    LIMIT $limit");
    }

    public function get_content()
    {
        global $OUTPUT;
        global $DB;

        $this->page->requires->css('/blocks/studia_news/lib.css');

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';
        $this->title = "Block Studia News";

        // Add logic here to define your template data or any other content.
        
        // get tag name
        if(!empty($this->config->tag)) {
            $tag = $this->config->tag;
        } else {
            $tag = "pengumuman";
        }

        // get limit 
        if(!empty($this->config->limit)) {
            $limit = $this->config->limit;
        } else {
            $limit = 2;
        }
        
        $pages = $this->get_pages($limit, $tag);

        foreach($pages as $page) {
            $page->url = new moodle_url('/mod/page/view.php', array("id" => $page->instance_id));
        }
        // echo '<pre>';
        // print_r($pages);
        // echo '</pre>';

        $this->content->text = $OUTPUT->render_from_template("block_studia_news/news", array("pages" => array_values($pages)));

        return $this->content;
    }

    public function applicable_formats()
    {
        return [
            'site-index' => true
        ];
    }

    public function instance_allow_multiple()
    {
        return true;
    }

    public function hide_header()
    {
        return true;
    }
}