<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

public $components = array(
	'Session',
	'Acl', // enable acl
	'Auth' => array(
		'loginAction' => array('controller' => 'users','action' => 'login'),
		'authError' => 'You must be logged in to view this page',
		'loginError' => 'Invalid Username or Password entered, please try',
		'authenticate' => array('Form' => array('fields' => array('username' => 'email'))),
	)
);

	public function beforeFilter() {
        $this->Auth->allow('login');
        $this->Auth->authorize = 'actions'; // acl authorising actions
        $this->Auth->actionPath = 'controllers/'; // for reading acl paths
        $this->Acl->Aco->create(array('parent_id' => null, 'alias' => 'controllers')); // create 'controller' aco if it doesnt exist - this enables all functions so it is for super users

		$role = $this->Auth->User('role_id'); // define user roles

		// restrict to user types...
		/*
			1 = Super User
			2 = Office Volunteer
			3 = Course Conveyor
			4 = Teaching Staff
			5 = Member

			On occasions, we use:
				<?php $getuser = $this->Session->read('Auth.User'); ?>
				OR
				<?php $user = $this->Session->read('Auth.User'); ?>
			To define user roles and then in the view...
				<?php
					if ($getuser['role_id'] == 1 || $getuser['role_id'] == 2) {
						...
					}
				?>
			To restrict certain buttons to different user types
		*/
   	}
	
	public function isAuthorized($user) {
		// Here is where we should verify the role and give access based on role
		
		return true;
	}
}