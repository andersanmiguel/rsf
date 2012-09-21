<?php 

class User extends Controller {

    function index() {
        $user = new Users();
        $user_array = $user->show_by_name('Ander');
        $this->load->render($user_array[0]['ip_user']);
    }

    function show() {
        $user = new Users();
        $user_array = $user->show('1');
        $this->load->render($user_array[0]['user']);
    }
}
