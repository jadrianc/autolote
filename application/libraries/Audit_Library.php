<?php defined('BASEPATH') or exit('No direct script access allowed');

class Audit_Library
{
    public function __construct()
    {
        $this->CI =& get_instance();
    }


    public function diffInData($oldRecords, $newRecords)
    {
        $old = (array) $oldRecords;
        $new = (array) $newRecords;
        $result = array_diff_assoc($new, $old);
        return $result;
    }
}