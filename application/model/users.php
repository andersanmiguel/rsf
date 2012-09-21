<?php 

class Users extends Model {

    function show($user = '') {
        if($user == '') {
            return $this->db->get('users');
        } else {
            $this->db->where('id', '1');
            return $this->db->get('users');
        }
    } 

    function show_by_name($user = '') {
        if($user == '') {
            return $this->db->get('users');
        } else {
            $this->db->where('user', $user, 'LIKE');
            return $this->db->get('users');
        }
    } 



}
