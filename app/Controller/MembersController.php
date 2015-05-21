<?php
/**
 * Members Controller
 */
App::uses('AppController', 'Controller');

class MembersController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allowedActions = array('add');
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$conditions = array();
			//Transform POST into GET
			if(($this->request->is('post') || $this->request->is('put')) && isset($this->data['Filter'])) {
				$filter_url['controller'] = $this->request->params['controller'];
				$filter_url['action'] = $this->request->params['action'];
				// We need to overwrite the page every time we change the parameters
				$filter_url['page'] = 1;

				// for each filter we will add a GET parameter for the generated url
				foreach($this->data['Filter'] as $name => $value) {
					if($value) {
						// You might want to sanitize the $value here
						// or even do a urlencode to be sure
						$filter_url[$name] = urlencode($value);
					}
				}       
					// now that we have generated an url with GET parameters, 
					// we'll redirect to that page
					return $this->redirect($filter_url);
			} 
				
			else {
				// Inspect all the named parameters to apply the filters
				foreach($this->params['named'] as $param_name => $value) {
					// Don't apply the default named parameters used for pagination
					if(!in_array($param_name, array('page','sort','direction','limit'))) {
						// You may use a switch here to make special filters
						// like "between dates", "greater than", etc
						if($param_name == "search") {
							$conditions['OR'] = array(
								array('Member.member_gname LIKE' => '%' . $value . '%'),
								array('Member.member_mname LIKE' => '%' . $value . '%'),
								array('Member.member_fname LIKE' => '%' . $value . '%'),
							);
						} 
						
						else {
							$conditions['Member.'.$param_name] = $value;
						}                                       
							$this->request->data['Filter'][$param_name] = $value;
					}
				}
			}
			
			$this->Member->recursive = 0;
			
			$this->set('members', $this->paginate());

			// get the possible values for the filters and 
			// pass them to the view
			// $genres = $this->Member->Course->find('list');
			// $directors = $this->Member->User->find('list');
			$this->set(compact('member_gname', 'member_mname', 'member_fname'));

			// Pass the search parameter to highlight the text
			$this->set('search', isset($this->params['named']['search']) ? $this->params['named']['search'] : "");
	}
	
/**
 * inactive_list method
 * for activating members
 */
	public function inactive_list() {
		$this->Member->recursive = 0;
		$this->set('members', $this->paginate());
	}

/**
 * activate method
 * for activation
 */
	public function activate($id = null, $u_id = null) {
		$this->Member->id = $id;
		$this->Member->User->id = $u_id;
		$options = array('conditions' => array('Member.' . $this->Member->primaryKey => $id));

		if (!$this->Member->exists($id)) {
			throw new NotFoundException(__('Invalid member'));
		}	
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Member->save($this->request->data)) {

				if ($u_id != null) {
					// data holds the sequence
					$data = array('id' => $this->Member->User->id, 'active' => '1');
					// This will update User id
					$this->Member->User->save($data);
				}

				$this->Session->setFlash(__('The member has been activated'));
				$this->redirect(array('action' => 'detailedmember/'. $id));
			} else {
				$this->Session->setFlash(__('The member could not be activated. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Member.' . $this->Member->primaryKey => $id));
			$this->request->data = $this->Member->find('first', $options);
		}
		$this->set('member', $this->Member->find('first', $options));
	}

/**
 * deactivate method
 * for deactivation
 */
	public function deactivate($id = null, $u_id = null) {
		$this->Member->id = $id;
		$this->Member->User->id = $u_id;

		if (!$this->Member->exists($id)) {
			throw new NotFoundException(__('Invalid member'));
		}	
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Member->save($this->request->data)) {

				if ($u_id != null) {
					// data holds the sequence
					$data = array('id' => $this->Member->User->id, 'active' => '0');
					// This will update User id
					$this->Member->User->save($data);
				}

				$this->Session->setFlash(__('The member has been deactivated'));
				$this->redirect(array('action' => 'detailedmember/'. $id));
			} else {
				$this->Session->setFlash(__('The member could not be deactivated. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Member.' . $this->Member->primaryKey => $id));
			$this->request->data = $this->Member->find('first', $options);
		}
		$this->set('member', $this->Member->find('first', $options));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function detailedmember($id = null, $c_id = null) {
		$return_id = $c_id; // sets the current id in controller to the one in the view url
		$this->set('return_id', $return_id); // access this variable in the view

		if (!$this->Member->exists($id)) {
			throw new NotFoundException(__('Invalid member'));
		}
		$options = array('conditions' => array('Member.' . $this->Member->primaryKey => $id));
		$this->set('member', $this->Member->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {

		if ($this->request->is('post')) {
			# debug($this->data);
			$this->Member->create();
			
			if ($this->Member->save($this->request->data)) {
				$this->Session->setFlash(__('The member has been saved'));
				$this->redirect(array("controller" => "Members", "action" => "detailedmember/", $this->Member->id));
			} 
			else {
				$this->Session->setFlash(__('The member could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {

		$options = array('conditions' => array('Member.' . $this->Member->primaryKey => $id));
		
		if (!$this->Member->exists($id)) {
			throw new NotFoundException(__('Invalid member'));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Member->save($this->request->data)) {
				$this->Session->setFlash(__('Member updated!'));
				$getuser = $this->Session->read('Auth.User');

				if ($id == $getuser['member_id']) {
					$this->redirect(array('action' => 'profile/' . $id));
				}

				else {
					$this->redirect(array('action' => 'detailedmember/' . $id));
				}
			} 

			else {
				$this->Session->setFlash(__('The member could not be saved. Please, try again.'));
			}

		} 

		else {
			
			$this->request->data = $this->Member->find('first', $options);
		}
		
		$this->set('member', $this->Member->find('first', $options));
	}

	public function edit_profile($id = null) {

		$options = array('conditions' => array('Member.' . $this->Member->primaryKey => $id));
		
		if (!$this->Member->exists($id)) {
			throw new NotFoundException(__('Invalid member'));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Member->save($this->request->data)) {
				$this->Session->setFlash(__('Member updated!'));
				$getuser = $this->Session->read('Auth.User');

				if ($id == $getuser['member_id']) {
					$this->redirect(array('action' => 'profile/' . $id));
				}

				else {
					$this->redirect(array('action' => 'detailedmember/' . $id));
				}
			} 

			else {
				$this->Session->setFlash(__('The member could not be saved. Please, try again.'));
			}

		} 

		else {
			
			$this->request->data = $this->Member->find('first', $options);
		}
		
		$this->set('member', $this->Member->find('first', $options));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Member->id = $id;
		if (!$this->Member->exists()) {
			throw new NotFoundException(__('Invalid member'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Member->delete()) {
			$this->Session->setFlash(__('Member deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Member was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	/**
 * view member profile method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function profile($id = null) {
		if (!$this->Member->exists($id)) {
			throw new NotFoundException(__('Invalid member'));
		}
		$options = array('conditions' => array('Member.' . $this->Member->primaryKey => $id));
		$this->set('member', $this->Member->find('first', $options));
	}
}