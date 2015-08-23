<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 *
 * @package phpMyAdmin
 */

/**
 * This class is inherited by all schema classes
 * It contains those methods which are common in them
 * it works like factory pattern
 *
 * @name Export Relation Schema
 * @copyright
 * @license
 */

class PMA_Export_Relation_Schema
{
    private $_pageTitle;
    public $showGrid;
    public $showColor;
    public $tableDimension;
    public $sameWide;
    public $withDoc;
    public $showKeys;
    public $orientation;
    public $paper;
    public $pageNumber;

    /**
     * Set Page Number
     *
     * @param integer value Page Number of the document to be created
     * @return void
     * @access public
     */
    public function setPageNumber($value)
    {
        $this->pageNumber = isset($value) ? $value : 1;
    }

    /**
     * Set Show Grid
     *
     * @param boolean value show grid of the document or not
     * @return void
     * @access public
     */
    public function setShowGrid($value)
    {
        $this->showGrid = (isset($value) && $value == 'on') ? 1 : 0;
    }

    public function setShowColor($value)
    {
        $this->showColor = (isset($value) && $value == 'on') ? 1 : 0;
    }

    /**
     * Set Table Dimension
     *
     * @param boolean value show table co-ordinates or not
     * @return void
     * @access public
     */
    public function setTableDimension($value)
    {
        $this->tableDimension = (isset($value) && $value == 'on') ? 1 : 0;
    }

    /**
     * Set same width of All Tables
     *
     * @param boolean value set same width of all tables or not
     * @return void
     * @access public
     */
    public function setAllTableSameWidth($value)
    {
        $this->sameWide = (isset($value) && $value == 'on') ? 1 : 0;
    }

    /**
     * Set Data Dictionary
     *
     * @param boolean value show selected database data dictionary or not
     * @return void
     * @access public
     */
    public function setWithDataDictionary($value)
    {
        $this->withDoc = (isset($value) && $value == 'on') ? 1 : 0;
    }

    /**
     * Set Show only keys
     *
     * @param boolean value show only keys or not
     * @return void
     * @access public
     */
    public function setShowKeys($value)
    {
        $this->showKeys = (isset($value) && $value == 'on') ? 1 : 0;
    }

    /**
     * Set Orientation
     *
     * @param string value Orientation will be portrait or landscape
     * @return void
     * @access public
     */
    public function setOrientation($value)
    {
        $this->orientation = (isset($value) && $value == 'P') ? 'P' : 'L';
    }

    /**
     * Set type of paper
     *
     * @param string value paper type can be A4 etc
     * @return void
     * @access public
     */
    public function setPaper($value)
    {
        $this->paper = isset($value) ? $value : 'A4';
    }

    /**
     * Set title of the page
     *
     * @param string value title of the page displayed at top of the document
     * @return void
     * @access public
     */
    public function setPageTitle($title)
    {
        $this->_pageTitle=$title;
    }

    /**
     * Set type of export relational schema
     *
     * @param string value can be pdf,svg,dia,visio,eps etc
     * @return void
     * @access public
     */
    public function setExportType($value)
    {
        $this->exportType=$value;
    }

    /**
     * get all tables involved or included in page
     *
     * @param string db name of the database
     * @param integer pageNumber page number whose tables will be fetched in an array
     * @return Array an array of tables
     * @access public
     */
    public function getAllTables($db,$pageNumber)
    {
        global $cfgRelation;
         // Get All tables
        $tab_sql = 'SELECT table_name FROM ' . PMA_backquote($GLOBALS['cfgRelation']['db']) . '.' . PMA_backquote($cfgRelation['table_coords'])
                . ' WHERE db_name = \'' . PMA_sqlAddslashes($db) . '\''
                . ' AND pdf_page_number = ' . $pageNumber;

        $tab_rs = PMA_query_as_controluser($tab_sql, null, PMA_DBI_QUERY_STORE);
        if (!$tab_rs || !PMA_DBI_num_rows($tab_rs) > 0) {
            $this->dieSchema('',__('This page does not contain any tables!'));
        }
        while ($curr_table = @PMA_DBI_fetch_assoc($tab_rs)) {
            $alltables[] = PMA_sqlAddslashes($curr_table['table_name']);
        }
        return $alltables;
    }

    /**
     * Displays an error message
     *
     * @param integer pageNumber ID of the chosen page
     * @param string type Schema Type
     * @param string error_message the error mesage
     * @global array    the PMA configuration array
     * @global integer  the current server id
     * @global string   the current language
     * @global string   the charset to convert to
     * @global string   the current database name
     * @global string   the current charset
     * @global string   the current text direction
     * @global string   a localized string
     * @global string   an other localized string
     * @access public
     * @return void
     */
    function dieSchema($pageNumber, $type = '', $error_message = '')
    {
        global $cfg;
        global $server, $lang, $convcharset, $db;
        global $charset, $text_dir;

        require_once './libraries/header.inc.php';
        echo "<p><strong>" . __("SCHEMA ERROR: ") .  $type ."</strong></p>" . "\n";
        if (!empty($error_message)) {
            $error_message = htmlspecialchars($error_message);
        }
        echo '<p>' . "\n";
        echo '    ' . $error_message . "\n";
        echo '</p>' . "\n";
        echo '<a href="schema_edit.php?' . PMA_generate_common_url($db).'&do=selectpage&chpage='.$pageNumber.'&action_choose=0'
         . '">' . __('Back') . '</a>';
        echo "\n";
        require_once './libraries/footer.inc.php';
        exit();
    }
}
?>
