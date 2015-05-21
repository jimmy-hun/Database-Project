<?php
App::uses('AppController', 'Controller');
/**
 * Courseenrolments Controller
 *
 * @property Courseenrolment $Courseenrolment
 */
class CourseenrolmentsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	
	public function course_members($id = null) {
		$c_id = $id; // sets the current id in controller to the one in the view url
		$this->set('c_id', $c_id); // access this variable in the view via $c_id

		$this->Courseenrolment->recursive = 0;
		$this->set('courseenrolments', $this->paginate());
	}


/**
 * add method
 *
 * @return void
 */
	public function add($id = null) {
		$this->set('c_id', $id);
		$this->Courseenrolment->Course->id = $id;

	    if (!$id) {
			$this->Session->setFlash('Please provide a course id.');
			$this->redirect(array('controller' => 'courses', 'action'=>'index'));
		}

		$course = $this->Courseenrolment->Course->findById($id);
		if (!$course) {
			$this->Session->setFlash('Invalid Course ID Provided.');
			$this->redirect(array('controller' => 'courses', 'action'=>'index'));
		}

		if ($this->request->is('post')) {
			$this->Courseenrolment->create();
			if ($this->Courseenrolment->save($this->request->data)) {
				$this->Session->setFlash(__('Enrolment details saved.'));
				$this->redirect(array('controller' => 'courses', 'action' => 'detailedcourse', $id));
			} 
			else {
				$this->Session->setFlash(__('This member is already enrolled.'));
			}
		}
		$courses = $this->Courseenrolment->Course->find('list');
		$members = $this->Courseenrolment->Member->find('list');
		$this->set(compact('courses', 'members'));

		$this->Courseenrolment->recursive = 0;
		$this->set('courseenrolments', $this->paginate());
	}
	
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	//public function edit($id = null, $c_id = null, $c_name = null) {
	public function edit($id = null, $c_id = null) {
		$this->Courseenrolment->id = $id;
		$co_id = $c_id; // sets the current id in controller to the one in the view url
		// $co_name = $c_name; // save course name as $co_name
		$this->set('c_id', $co_id); // access this variable in the view via $c_id
		// $this->set('c_name', $co_name); // access this variable in the view via $c_id

		if (!$this->Courseenrolment->exists($id)) {
			throw new NotFoundException(__('Invalid enrollment.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Courseenrolment->save($this->request->data)) {
				$this->Session->setFlash(__('The enrollment has been saved.'));
				$this->redirect(array('action' => 'course_members', $co_id));
			} else {
				$this->Session->setFlash(__('The enrollment could not be saved. Please, try again.'));
			}
		} 

		else {
			$options = array('conditions' => array('Courseenrolment.' . $this->Courseenrolment->primaryKey => $id));
			$this->request->data = $this->Courseenrolment->find('first', $options);
		}

		$courses = $this->Courseenrolment->Course->find('list');
		$members = $this->Courseenrolment->Member->find('list');
		$this->set(compact('courses', 'members'));

		$this->Courseenrolment->recursive = 0;
		$this->set('courseenrolments', $this->paginate());
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null, $c_id = null) {
		$this->Courseenrolment->id = $id;
		if (!$this->Courseenrolment->exists()) {
			throw new NotFoundException(__('Invalid enrollment.'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Courseenrolment->delete()) {
			$this->Session->setFlash(__('Enrollment deleted.'));
			$this->redirect(array('controller' => 'courses', 'action' => 'detailedcourse/', $c_id));
		}
		$this->Session->setFlash(__('Enrollment could not be cancelled.'));
		$this->redirect(array('controller' => 'courses', 'action' => 'detailedcourse/', $c_id));
	}
}
