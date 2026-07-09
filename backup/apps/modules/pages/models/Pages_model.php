<?php

date_default_timezone_set('Asia/Kolkata');
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Pages_model extends MY_Model {
  public function get_cms_page($page = array()) {
    if (is_array($page) && !empty($page)) {
      $result = $this->db->get_where('wps_cms_pages', $page)->row_array();
      if (is_array($result) && !empty($result)) {
        return $result;
      }
    }
  }

  public function get_all_cms_page($offset = '0', $limit = '10') {
    $keyword = $this->db->escape_str($this->input->get_post('keyword'));
    $condtion = ($keyword != '') ? "status !='2' AND page_name LIKE '%" . $keyword . "%'" : "status !='2' ";
    $fetch_config = array(
        'condition' => $condtion,
        'order' => "page_name DESC",
        'limit' => $limit,
        'start' => $offset,
        'debug' => FALSE,
        'return_type' => "array"
    );

    $result = $this->findAll('wps_cms_pages', $fetch_config);
    return $result;
  }

  public function timeDiff($firstTime, $lastTime) {
    $time = $lastTime;
    // convert to unix timestamps
    $firstTime = strtotime($firstTime);
    $lastTime = strtotime($lastTime);
    $rt = "";
    //perform subtraction to get the difference (in seconds) between times
    $timeDiff = $firstTime - $lastTime;
    
    // return the difference
    if ($timeDiff > 60) {
      if ($timeDiff > 60 && $timeDiff < 1440) {
        $timeDiff = $timeDiff / 60;
        $rt = ceil($timeDiff) . ' minutes ago';
      } elseif ($timeDiff > 1440 && $timeDiff < 86400) {
        $timeDiff = $timeDiff / (60 * 60);
        $rt = 'about ' . ceil($timeDiff) . ' hours ago';
      } elseif ($timeDiff > 86400 && $timeDiff < 172800) {
        $timeDiff = $timeDiff / (60 * 60 * 2);
        $tm = explode(' ', $time);
        $rt = "yesterday"; // at " . $tm[1];
      } else {
        $timeDiff = $timeDiff / (24 * 60 * 60);
        $rt = ceil($timeDiff) . " days ago";
      }
    } else {
      $rt = $timeDiff . " seconds ago";
    }
    return $rt;
  }

  public function get_date($date, $time) {
    if (($time == 'morning')) {
      $cond = "slotTime >= '09:00:00' AND slotTime <= '11:00:00' AND slotDate='$date'";
    } elseif (($time == 'noon')) {
      $cond = "slotTime >= '13:00:00' AND slotTime <= '15:00:00' AND slotDate='$date'";
    } elseif (($time == 'evening')) {
      $cond = "slotTime >= '17:00:00' AND slotTime <= '19:00:00' AND slotDate='$date'";
    }
    $result = $this->db->query("SELECT * FROM wps_collector_scheduler WHERE " . $cond . "  GROUP by slotTime order by slotTime")->result_array();
    if (count($result) > 0) {
      return $result;
    } else {
      return FALSE;
    }
  }
}