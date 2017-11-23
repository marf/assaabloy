<?php

class User_Model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                $this->load->database();
        }

        public function login($username, $password)
        {
            $condition = "username =" . "'" . $username. "' AND " . "password =" . "'" . $password . "'";
            $this->db->select('*');
            $this->db->from('login');
            $this->db->where($condition);
            $this->db->limit(1);
            $query = $this->db->get();
            
            if ($query->num_rows() == 1) {
                foreach ($query->result() as $row)
                {
                        $this->session->set_userdata('userID', $row->id);
                        $this->session->set_userdata('email', $row->email);
                        $this->session->set_userdata('permission', $row->permission);
                }
                return true;
            } else {
                return false;
            }
        }


}

?>