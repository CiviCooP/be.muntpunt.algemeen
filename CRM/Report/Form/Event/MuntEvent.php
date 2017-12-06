<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.6                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2015                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
 */

/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2015
 * $Id$
 *
 */
class CRM_Report_Form_Event_MuntEvent extends CRM_Report_Form_Event {

  protected $_summary = NULL;

  protected $_add2groupSupported = FALSE;

  protected $_customGroupExtends = array(
    'Event',
  );

  public $_drilldownReport = array('event/income' => 'Link to Detail Report');

  /**
   */
  /**
   */
  public function __construct() {
    $this->_columns = array(
      'civicrm_event' => array(
        'dao' => 'CRM_Event_DAO_Event',
        'grouping' => 'event-fields',
        'fields' => array(
          'id' => array(
            'no_display' => TRUE,
            'required' => TRUE,
          ),
          'title' => array(
            'title' => ts('Event Title'),
            'required' => TRUE,
          ),
          'event_type_id' => array(
            'title' => ts('Event Type'),
            'required' => TRUE,
          ),
          'summary' => array('title' => ts('Event Summary')),
          'description' => array('title' => ts('Complete Description')),
          'event_start_date' => array(
            'title' => ts('Event Start Date'),
          ),
          'event_end_date' => array('title' => ts('Event End Date')),
          'is_map' => array('title' => ts('Include Map to Event Location')),
          'is_public' => array('title' => ts('Public Event')),
          'is_share' => array('title' => ts('Allow Sharing Through Social Media')),
          'is_active' => array('title' => ts('Is this event Active?')),
          'max_participants' => array(
            'title' => ts('Capacity'),
            'type' => CRM_Utils_Type::T_INT,
          ),
          'is_show_location' => array('title' => ts('Show Location')),
        ),
        'filters' => array(
          'id' => array(
            'title' => ts('Event'),
            'operatorType' => CRM_Report_Form::OP_ENTITYREF,
            'type' => CRM_Utils_Type::T_INT,
            'attributes' => array('select' => array('minimumInputLength' => 0)),
          ),
          'event_type_id' => array(
            'name' => 'event_type_id',
            'title' => ts('Event Type'),
            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
            'options' => CRM_Core_OptionGroup::values('event_type'),
          ),
          'event_start_date' => array(
            'title' => 'Event Start Date',
            'operatorType' => CRM_Report_Form::OP_DATE,
          ),
          'event_end_date' => array(
            'title' => 'Event End Date',
            'operatorType' => CRM_Report_Form::OP_DATE,
          ),
        ),
      ),
      'civicrm_action_schedule' => array(
        'dao' => 'CRM_Core_DAO_ActionSchedule',
        'fields' => array(
          'is_active' => array(
          'title' => ts('Schedule Reminders')
          ),
        ) ,
        'grouping' => 'event-fields',
        ),
      'civicrm_phone' => array(
        'dao' => 'CRM_Core_DAO_Phone',
        'fields' => array(
          'phone' => array(
            'title' => ts('Phone'),
            'default' => TRUE,
            'no_repeat' => TRUE,
          ),
        ),
        'grouping' => 'event-fields',
      ),
      'civicrm_email' => array(
        'dao' => 'CRM_Core_DAO_Email',
        'fields' => array(
          'email' => array(
            'title' => ts('Email')
            ),
          ),
        'grouping' => 'event-fields',
        ),
      'civicrm_address' => array(
        'dao' => 'CRM_Core_DAO_Address',
        'fields' => array(
          'address_name' => array(
            'title' => ts('Address Name'),
            ),
          ),
        'grouping' => 'event-fields',
        ),
      'civicrm_loc_block' => array(
        'dao' => 'CRM_Core_DAO_LocBlock',
        'grouping' => 'event-fields',
        'fields' => array(
          'id' => array(
            'title' => ts('Loc Block Id'),
            'default' => TRUE,
            'no_display' => TRUE,
            ),
          'email_id' => array(
            'title' => ts('Email'),
            'default' => TRUE,
            'no_display' => TRUE,
            ),
          'address_id' => array(
            'title' => ts('Use location') ,
            ),
          ),
        ),
      'civicrm_recurring_entity' => array(
        'dao' => 'CRM_Core_DAO_RecurringEntity',
        'fields' => array(
          'id' => array('title' => ts('Repeat enabled?'))
        ),
        'grouping' => 'event-fields',
      ),
      'civicrm_tell_friend' => array(
        'dao' => 'CRM_Friend_DAO_Friend',
        'fields' => array(
          'general_link' => array(
            'title' => ts('Tell a Friend enabled?')),
          ),
        'grouping' => 'event-fields',
        ),
      'civicrm_campaign' => array(
        'dao' => 'CRM_Campaign_DAO_Campaign',
        'fields' => array(
          'name' => array(
            'title' => ts('Personal Campaign')
            ),
          ),
        'filters' => array(
          'civicrm_campaign_id' => array(
            'title' => ts('Event Campaign'),
            'operatorType' => CRM_Report_Form::OP_ENTITYREF,
            'type' => CRM_Utils_Type::T_INT,
          ),
        ),       
        'grouping' => 'event-fields',
        ),
    );

    $this->_currencyColumn = 'civicrm_participant_fee_currency';
    parent::__construct();
  }

  public function preProcess() {
    parent::preProcess();
  }

  public function select() {
    $select = array();
    foreach ($this->_columns as $tableName => $table) {
      if (array_key_exists('fields', $table)) {
        foreach ($table['fields'] as $fieldName => $field) {
          if (!empty($field['required']) ||
            !empty($this->_params['fields'][$fieldName])
          ) {
            if($fieldName == 'general_link'){
              $select[] = "{$field['dbAlias']} as {$tableName}_is_active";
            } else{
              $select[] = "{$field['dbAlias']} as {$tableName}_{$fieldName}";
            }
          }
        }
      }
    }

    $this->_select = 'SELECT ' . implode(', ', $select);
  }

  public function from() {
    $this->_from = " FROM civicrm_event {$this->_aliases['civicrm_event']}
            LEFT JOIN civicrm_loc_block  {$this->_aliases['civicrm_loc_block']}
                ON {$this->_aliases['civicrm_loc_block']}.id = {$this->_aliases['civicrm_event']}.loc_block_id
            LEFT JOIN civicrm_phone  {$this->_aliases['civicrm_phone']}
                ON {$this->_aliases['civicrm_phone']}.id = {$this->_aliases['civicrm_loc_block']}.phone_id AND
                  {$this->_aliases['civicrm_phone']}.is_primary = 1
        ";

    // Custom Code
    // Address Name
    if(strpos($this->_select, 'civicrm_address_address_name')) {
      $this->_from .= "
            LEFT JOIN civicrm_address {$this->_aliases['civicrm_address']}
                ON {$this->_aliases['civicrm_address']}.id = {$this->_aliases['civicrm_loc_block']}.address_id
      ";
    }

    // Email
    if (strpos($this->_select, 'civicrm_email_email')) {
      $this->_from .= "
            LEFT JOIN civicrm_email {$this->_aliases['civicrm_email']}
                ON {$this->_aliases['civicrm_email']}.id = {$this->_aliases['civicrm_loc_block']}.email_id
      ";
    }

    // Tell a friend
    if (strpos($this->_select, 'civicrm_tell_friend_is_active')) {
      $this->_from .= "
            LEFT JOIN civicrm_tell_friend {$this->_aliases['civicrm_tell_friend']}
                  ON ({$this->_aliases['civicrm_tell_friend']}.entity_id = {$this->_aliases['civicrm_event']}.id )
      ";
    }

    // Schedule Reminders
    if (strpos($this->_select, 'action_schedule_civireport')) {
      $this->_from .= "
            LEFT JOIN civicrm_action_schedule {$this->_aliases['civicrm_action_schedule']}
                  ON ({$this->_aliases['civicrm_action_schedule']}.entity_value = {$this->_aliases['civicrm_event']}.id )
      ";
    }

    // Repeat
    if (strpos($this->_select, 'recurring_entity_civireport')) {
      $this->_from .= "
            LEFT JOIN civicrm_recurring_entity {$this->_aliases['civicrm_recurring_entity']}
                  ON ({$this->_aliases['civicrm_recurring_entity']}.parent_id = {$this->_aliases['civicrm_event']}.id )
                  AND {$this->_aliases['civicrm_recurring_entity']}.entity_table = 'civicrm_event'
      ";
    }

    // Campaign
      $this->_from .= "
            LEFT JOIN civicrm_campaign {$this->_aliases['civicrm_campaign']}
                ON {$this->_aliases['civicrm_campaign']}.id = {$this->_aliases['civicrm_event']}.campaign_id
                AND {$this->_aliases['civicrm_campaign']}.is_active = 1
      ";

    // Custom Coed ends
  }

  public function where() {
    $clauses = array();
    $this->_participantWhere = "";
    foreach ($this->_columns as $tableName => $table) {
      if (array_key_exists('filters', $table)) {
        foreach ($table['filters'] as $fieldName => $field) {
          $clause = NULL;
          if (CRM_Utils_Array::value('type', $field) & CRM_Utils_Type::T_DATE) {
            $relative = CRM_Utils_Array::value("{$fieldName}_relative", $this->_params);
            $from = CRM_Utils_Array::value("{$fieldName}_from", $this->_params);
            $to = CRM_Utils_Array::value("{$fieldName}_to", $this->_params);

            if ($relative || $from || $to) {
              $clause = $this->dateClause($field['dbAlias'], $relative, $from, $to, $field['type']);
            }
          }
          else {
            $op = CRM_Utils_Array::value("{$fieldName}_op", $this->_params);
            if ($op) {
              $clause = $this->whereClause($field,
                $op,
                CRM_Utils_Array::value("{$fieldName}_value", $this->_params),
                CRM_Utils_Array::value("{$fieldName}_min", $this->_params),
                CRM_Utils_Array::value("{$fieldName}_max", $this->_params)
              );
            }
          }
          if (!empty($this->_params['id_value'])) {
            $this->_participantWhere = " AND civicrm_participant.event_id IN ( {$this->_params['id_value']} ) ";
          }

          if (!empty($clause)) {
            $clauses[] = $clause;
          }
        }
      }
    }
    $clauses[] = "{$this->_aliases['civicrm_event']}.is_template = 0";

    foreach ($clauses as $clauses_key => $clauses_value) {
      $where_clauses[] = str_replace("civicrm_campaign_id", "id", $clauses_value);
    }

    $this->_where = 'WHERE  ' . implode(' AND ', $where_clauses);

    // Custom code
    // Event online registration
    if (strpos($this->_select, 'is_online_registration')) {
      $this->_where .= " AND is_online_registration = 1" ;
    }

    // Tell a friend
    if (strpos($this->_select, 'civicrm_tell_friend_is_active')) {
      $this->_where .= " AND {$this->_aliases['civicrm_tell_friend']}.is_active = 1" ;
    }

    // Repeat
    if (strpos($this->_select, 'recurring_entity_civireport')) {
      $this->_where .= " AND {$this->_aliases['civicrm_recurring_entity']}.entity_table = 'civicrm_event'" ;
    }

    // Schedule reminders
    if (strpos($this->_select, 'action_schedule_civireport')) {
      $this->_where .= " AND {$this->_aliases['civicrm_action_schedule']}.is_active = 1";
    }

    // Allow sharing through social media
    if(strpos($this->_select, 'civicrm_event_is_share')) {
      $this->_where .= " AND {$this->_aliases['civicrm_event']}.is_share = 1";
    }

    // Event is public
    if(strpos($this->_select, 'civicrm_event_is_public')) {
      $this->_where .= " AND {$this->_aliases['civicrm_event']}.is_public = 1";
    }

    // Include Map to Event Location
    if(strpos($this->_select, 'civicrm_event_is_map')) {
      $this->_where .= " AND {$this->_aliases['civicrm_event']}.is_map = 1";
    }

    // Event is active
    if(strpos($this->_select, 'civicrm_event_is_active')) {
      $this->_where .= " AND {$this->_aliases['civicrm_event']}.is_active = 1";
    }
    // Custom code ends
  }

  public function groupBy() {
    $this->assign('chartSupported', TRUE);
    $this->_groupBy = " GROUP BY {$this->_aliases['civicrm_event']}.id";
  }

  /**
   * get participants information for events.
   * @return array
   */
  public function participantInfo() {

    $statusType1 = CRM_Event_PseudoConstant::participantStatus(NULL, 'is_counted = 1');
    $statusType2 = CRM_Event_PseudoConstant::participantStatus(NULL, 'is_counted = 0');

    $sql = "
          SELECT civicrm_participant.event_id    AS event_id,
                 civicrm_participant.status_id   AS statusId,
                 COUNT( civicrm_participant.id ) AS participant,
                 SUM( civicrm_participant.fee_amount ) AS amount,
                 civicrm_participant.fee_currency

            FROM civicrm_participant

            WHERE civicrm_participant.is_test = 0
                  $this->_participantWhere

        GROUP BY civicrm_participant.event_id,
                 civicrm_participant.status_id";

    $info = CRM_Core_DAO::executeQuery($sql);
    $participant_data = $participant_info = $currency = array();

    while ($info->fetch()) {
      $participant_data[$info->event_id][$info->statusId]['participant'] = $info->participant;
      $participant_data[$info->event_id][$info->statusId]['amount'] = $info->amount;
      $currency[$info->event_id] = $info->fee_currency;
    }

    $amt = $particiType1 = $particiType2 = 0;

    foreach ($participant_data as $event_id => $event_data) {
      foreach ($event_data as $status_id => $data) {

        if (array_key_exists($status_id, $statusType1)) {
          //total income of event
          $amt = $amt + $data['amount'];

          //number of Registered/Attended participants
          $particiType1 = $particiType1 + $data['participant'];
        }
        elseif (array_key_exists($status_id, $statusType2)) {

          //number of No-show/Cancelled/Pending participants
          $particiType2 = $particiType2 + $data['participant'];
        }
      }

      $participant_info[$event_id]['totalAmount'] = $amt;
      $participant_info[$event_id]['statusType1'] = $particiType1;
      $participant_info[$event_id]['statusType2'] = $particiType2;
      $participant_info[$event_id]['currency'] = $currency[$event_id];
      $amt = $particiType1 = $particiType2 = 0;
    }

    return $participant_info;
  }

  /**
   * Build header for table.
   */
  public function buildColumnHeaders() {
    $this->_columnHeaders = array();
    foreach ($this->_columns as $tableName => $table) {
      if (array_key_exists('fields', $table)) {
        foreach ($table['fields'] as $fieldName => $field) {
          if (!empty($field['required']) ||
            !empty($this->_params['fields'][$fieldName])
          ) {

            $this->_columnHeaders["{$tableName}_{$fieldName}"]['type'] = CRM_Utils_Array::value('type', $field);
            $this->_columnHeaders["{$tableName}_{$fieldName}"]['title'] = CRM_Utils_Array::value('title', $field);
          }
        }
      }
    }

    $statusType1 = CRM_Event_PseudoConstant::participantStatus(NULL, 'is_counted = 1');
    $statusType2 = CRM_Event_PseudoConstant::participantStatus(NULL, 'is_counted = 0');

    //make column header for participant status  Registered/Attended
    $type1_header = implode('/', $statusType1);

    //make column header for participant status No-show/Cancelled/Pending
    $type2_header = implode('/', $statusType2);

    $this->_columnHeaders['statusType1'] = array(
      'title' => $type1_header,
      'type' => CRM_Utils_Type::T_INT,
    );
    $this->_columnHeaders['statusType2'] = array(
      'title' => $type2_header,
      'type' => CRM_Utils_Type::T_INT,
    );
    $this->_columnHeaders['totalAmount'] = array(
      'title' => 'Total Income',
      'type' => CRM_Utils_Type::T_STRING,
    );
  }

  public function postProcess() {

    $this->beginPostProcess();

    $this->buildColumnHeaders();

    $sql = $this->buildQuery(TRUE);

    $dao = CRM_Core_DAO::executeQuery($sql);

    //set pager before exicution of query in function participantInfo()
    $this->setPager();

    $rows = $graphRows = array();
    $count = 0;
    while ($dao->fetch()) {
      $row = array();
      foreach ($this->_columnHeaders as $key => $value) {
        if (($key == 'civicrm_event_start_date') ||
          ($key == 'civicrm_event_end_date')
        ) {
          //get event start date and end date in custom datetime format
          $row[$key] = CRM_Utils_Date::customFormat($dao->$key);
        }
        else {
          if (isset($dao->$key)) {
            $row[$key] = $dao->$key;
          }
          if($key == 'civicrm_tell_friend_general_link'){
            $row['civicrm_tell_friend_is_active'] = $dao->civicrm_tell_friend_is_active;
          }
        }
      }
      $rows[] = $row;
    }
    if (!empty($rows)) {
      $participant_info = $this->participantInfo();
      foreach ($rows as $key => $value) {
        if (array_key_exists($value['civicrm_event_id'], $participant_info)) {
          foreach ($participant_info[$value['civicrm_event_id']] as $k => $v) {
            $rows[$key][$k] = $v;
          }
        }
      }
    }
    // do not call pager here
    $this->formatDisplay($rows, FALSE);
    unset($this->_columnHeaders['civicrm_event_id']);

    $this->doTemplateAssignment($rows);

    $this->endPostProcess($rows);
  }

  /**
   * @param $rows
   */
  public function buildChart(&$rows) {
    $this->_interval = 'events';
    $countEvent = NULL;
    if (!empty($this->_params['charts'])) {
      foreach ($rows as $key => $value) {
        $graphRows['totalAmount'][] = $graphRows['value'][] = CRM_Utils_Array::value('totalAmount', $rows[$key]);
        $graphRows[$this->_interval][] = substr($rows[$key]['civicrm_event_title'], 0, 12) . "..(" .
          $rows[$key]['civicrm_event_id'] . ") ";
      }

      if (CRM_Utils_Array::value('totalAmount', $rows[$key]) == 0) {
        $countEvent = count($rows);
      }

      if ((!empty($rows)) && $countEvent != 1) {
        $config = CRM_Core_Config::Singleton();
        $chartInfo = array(
          'legend' => 'Event Summary',
          'xname' => 'Event',
          'yname' => "Total Amount ({$config->defaultCurrency})",
        );
        if (!empty($graphRows)) {
          foreach ($graphRows[$this->_interval] as $key => $val) {
            $graph[$val] = $graphRows['value'][$key];
          }
          $chartInfo['values'] = $graph;
          $chartInfo['xLabelAngle'] = 20;

          // build the chart.
          CRM_Utils_OpenFlashChart::buildChart($chartInfo, $this->_params['charts']);
          $this->assign('chartType', $this->_params['charts']);
        }
      }
    }
  }

  /**
   * Alter display of rows.
   *
   * Iterate through the rows retrieved via SQL and make changes for display purposes,
   * such as rendering contacts as links.
   *
   * @param array $rows
   *   Rows generated by SQL, with an array for each row.
   */
  public function alterDisplay(&$rows) {
    if (is_array($rows)) {
      $eventType = CRM_Core_OptionGroup::values('event_type');

      foreach ($rows as $rowNum => $row) {
        if (array_key_exists('totalAmount', $row) &&
          array_key_exists('currency', $row)
        ) {
          $rows[$rowNum]['totalAmount'] = CRM_Utils_Money::format($rows[$rowNum]['totalAmount'], $rows[$rowNum]['currency']);
        }
        if (array_key_exists('civicrm_event_title', $row)) {
          if ($value = $row['civicrm_event_id']) {
            //CRM_Event_PseudoConstant::event( $value, false );
            $url = CRM_Report_Utils_Report::getNextUrl('event/income',
              'reset=1&force=1&id_op=in&id_value=' . $value,
              $this->_absoluteUrl, $this->_id, $this->_drilldownReport
            );
            $rows[$rowNum]['civicrm_event_title_link'] = $url;
            $rows[$rowNum]['civicrm_event_title_hover'] = ts('View Event Income For this Event');
          }
        }

        // Custom Code starts
        if(array_key_exists('civicrm_event_is_online_registration', $row) && !empty($rows[$rowNum]['civicrm_event_is_online_registration']) ) {
          if($row['civicrm_event_is_online_registration'] == 1) {
            $rows[$rowNum]['civicrm_event_is_online_registration'] = 'Yes';
          }
        }
        if(array_key_exists('civicrm_tell_friend_is_active', $row) && !empty($rows[$rowNum]['civicrm_tell_friend_is_active']) ) {
          if($row['civicrm_tell_friend_is_active'] == 1 ) {
            $rows[$rowNum]['civicrm_tell_friend_general_link'] = 'Yes';
          }
        }
        if(array_key_exists('civicrm_recurring_entity_id', $row) && !empty($rows[$rowNum]['civicrm_event_is_share'])) {
          $rows[$rowNum]['civicrm_recurring_entity_id'] = 'Yes';
        }
        if((array_key_exists('civicrm_action_schedule_is_active', $row)) && !empty($rows[$rowNum]['civicrm_action_schedule_is_active'])) {
          $rows[$rowNum]['civicrm_action_schedule_is_active'] = 'Yes';
        }
        if((array_key_exists('civicrm_event_is_share', $row)) && !empty($rows[$rowNum]['civicrm_event_is_share'])) {
          $rows[$rowNum]['civicrm_event_is_share'] = 'Yes';
        }
        if((array_key_exists('civicrm_event_is_public', $row)) && !empty($rows[$rowNum]['civicrm_event_is_public'])) {
          $rows[$rowNum]['civicrm_event_is_public'] = 'Yes';
        }
        if((array_key_exists('civicrm_event_is_map', $row)) && !empty($rows[$rowNum]['civicrm_event_is_map'])) {
          $rows[$rowNum]['civicrm_event_is_map'] = 'Yes';
        }
        if((array_key_exists('civicrm_event_is_active', $row)) && !empty($rows[$rowNum]['civicrm_event_is_active'])) {
          $rows[$rowNum]['civicrm_event_is_active'] = 'Yes';
        }

        // Get a address of the event
        if((array_key_exists('civicrm_loc_block_address_id', $row)) && !empty($rows[$rowNum]['civicrm_loc_block_address_id'])) {
          $sql = "
            SELECT name, street_address, city
             FROM civicrm_address 
             where id = {$row['civicrm_loc_block_address_id']}
            ";
          $dao = CRM_Core_DAO::executeQuery($sql);
          while ($dao->fetch()) {
            $address['name'] = $dao->name;
            $address['street_address'] = $dao->street_address;
            $address['city'] = $dao->city;
          }
          $event_address = $address['name'] . ' :: ' . $address['street_address'] . ' :: ' . $address['city'];

          $rows[$rowNum]['civicrm_loc_block_address_id'] = $event_address;
        }

        // Recurring event
        if((array_key_exists('civicrm_recurring_entity_id', $row))) {
          $rows[$rowNum]['civicrm_recurring_entity_id'] = 'Yes';
        }

        // Show Location
        if((array_key_exists('civicrm_event_is_show_location', $row))) {
          $rows[$rowNum]['civicrm_event_is_show_location'] = 'Yes';
        } else {
          $rows[$rowNum]['civicrm_event_is_show_location'] = 'No';
        }

        // Description
        //if ((array_key_exists('civicrm_event_description', $row))) {
          // $row_descripotion = strip_tags($row['civicrm_event_description']);
          //$description = mb_strimwidth($row_descripotion, 0, 200, "...");
         // $rows[$rowNum]['civicrm_event_description'] = $description;
        //}
        // Custome code ends

        //handle event type
        if (array_key_exists('civicrm_event_event_type_id', $row)) {
          if ($value = $row['civicrm_event_event_type_id']) {
            $rows[$rowNum]['civicrm_event_event_type_id'] = $eventType[$value];
          }
        }
      }
    }
  }

}
