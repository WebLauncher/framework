<?php


/**
 * Ajax Table Class
 */
class AjaxTable
{
    var $id = 'not_assigned_table_id';
    var $header = array();
    var $data_type = 'text';
    var $content = array();
    var $actions = array();
    var $total = 0;
    var $update_action = 'update';
    var $edit_link = 'none';
    var $sort_dir = '';
    var $sort_by = '';
    var $sort_col_no = 0;
    var $search_keyword = '';

    /**
     * Constructor
     */
    function __construct()
    {
    }

    /**
     * Process current request
     */
    function process_request()
    {
        /**
         * @var System
         */
        
        if (isset($_GET['startIndex']) && $_GET['startIndex']) {
            System::getInstance()->page_skip = $_GET['startIndex'];
        }
        if (isset($_GET['numberOfRows']) && $_GET['numberOfRows']) {
            System::getInstance()->page_offset = $_GET['numberOfRows'];
        }
        if (isset($_GET['sortBy'])) {
            if (isset($_GET['sortAscending'])) {
                if ($_GET['sortAscending'] == 'false') $this->sort_dir = 'desc';
            }

            foreach ($this->header as $k => $v)
                if (!isset($v['sort']) && $_GET['sortBy'] == $v['col']) {
                    $this->sort_by = $v['col'];
                    $this->header[$k]['sort_dir'] = $this->sort_dir ? 0 : 1;
                }
        }
        if (isset($_GET['kwd']) && $_GET['kwd']) {
            $this->search_keyword = $_GET['kwd'];
        }
        System::getInstance()->session['pages'][$this->id] = System::getInstance()->page_skip / System::getInstance()->page_offset;
        System::getInstance()->saveSession();
    }

    /**
     * Get active search fields
     * @return array
     */
    function get_search_fields()
    {
        $fields = array();
        foreach ($this->header as $v)
            if (!isset($v['search']))
                $fields[] = $v['col'];

        return $fields;
    }

    /**
     * Get form in template version
     * @param int $data
     * @return array
     */
    function get_array($data = 0)
    {
        $table = array();
        $table['id'] = $this->id;
        $table['data'] = $data;
        $table['data_type'] = $this->data_type;
        $table['header'] = $this->header;
        $table['content'] = $this->content;
        $table['actions'] = $this->actions;
        $table['sort_by'] = $this->sort_by;
        $table['sort_dir'] = $this->sort_dir;
        $table['total'] = $this->total;
        $table['update_action'] = $this->update_action;
        $table['edit_link'] = $this->edit_link;

        return $table;
    }

    /**
     * Add content from db
     * @param mixed $content
     */
    function process_content($content)
    {
        foreach ($content as $row) {
            $this->add_row($row);
        }
    }

    /**
     * Add row from db
     * @param mixed $row
     */
    function add_row($row)
    {
        $new_row = array();
        foreach ($this->header as $col) {
            if (isset($row[$col['col']]))
                $new_row[$col['col']]['value'] = $row[$col['col']];
        }
        $this->content[] = $new_row;
    }

    /**
     * Add action to table
     * @param object|string $title [optional]
     * @param object|string $text [optional]
     * @param object|string $link [optional]
     * @param object|string $onclick [optional]
     * @param int|object $refresh [optional]
     * @param object|string $icon [optional]
     * @param string $confirm
     */
    function add_action($title = '', $text = '', $link = '', $onclick = '', $refresh = 1, $icon = '', $confirm = '')
    {
        $action = array(
            'title' => $title,
            'text' => $text,
            'link' => $link,
            'onclick' => $onclick,
            'refresh' => $refresh,
            'icon' => $icon,
            'confirm' => $confirm
        );

        $this->actions[] = $action;
    }

    /**
     * Display data function
     */
    function display_data()
    {
        /**
         * @var System
         */
        

        $table = $this->get_array(1);

        if ($table['data'] && $this->data_type == 'json') {
            echo json_encode($table, JSON_NUMERIC_CHECK);
            die;
        } else {
            System::getInstance()->assign('table', $table);
            echo System::getInstance()->template->fetch(System::getInstance()->objects['templates']['ajax_table']);
            die;
        }
    }
}