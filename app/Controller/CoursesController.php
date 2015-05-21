<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');


/**
 * Courses Controller
 *
 * @property Course $Course
 */
class CoursesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Course->recursive = 0;
		$this->set('courses', $this->paginate());
		
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function detailedcourse($id = null) {
		if (!$this->Course->exists($id)) {
			throw new NotFoundException(__('Invalid course.'));
		}
		$options = array('conditions' => array('Course.' . $this->Course->primaryKey => $id));
		$this->set('course', $this->Course->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Course->create();
			if ($this->Course->save($this->request->data)) {
				$this->Session->setFlash(__('The course has been saved.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course could not be saved. Please try again.'));
			}
		}
	}

// INITIAL CREATE
	public function enroll_now($id = null) {
		$this->Course->id = $id; // sets the current id in controller to the one in the view url
		$this->set('course_enroll', $this->Course->id); // access this variable in the view via $course_enroll

		if ($this->request->is('post')) {
			$this->Course->Courseenrolment->create();
			if ($this->Course->Courseenrolment->saveAssociated($this->request->data, array('atomic' => false, 'deep' => true))) {
				$this->Session->setFlash(__('Enrolment details saved.'));
				$this->redirect(array('action' => 'detailedcourse/', $id));
			}
			else {
				$this->Session->setFlash(__('ERROR'));
			}
		}
		$courses = $this->Course->Courseenrolment->Course->find('list');
		$members = $this->Course->Courseenrolment->Member->find('list');
		$this->set(compact('courses', 'members'));

		// enables stuff like echo h($course['Course']['course_code']);
		$options = array('conditions' => array('Course.' . $this->Course->primaryKey => $id)); // for correct indexing and ids
		$this->set('course', $this->Course->find('first', $options)); // so you can reference Course
	}

// HARD DELETE
	public function delete_enroll($id = null, $c_id = null) {
		$this->Course->Courseenrolment->id = $id; // sets passed value 1 from view as the course related courseenrolment id
		$this->Course->id = $c_id; // sets the 2nd passed value from the view as the id for course

		if (!$this->Course->Courseenrolment->exists()) {
			throw new NotFoundException(__('Invalid enrollment.'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Course->Courseenrolment->delete()) {
			$this->Session->setFlash(__('Member enrollment deleted.'));
			$this->redirect(array('action' => 'detailedcourse/', $c_id));
		}
		$this->Session->setFlash(__('Enrollment could not be deleted.'));
		$this->redirect(array('action' => 'detailedcourse/', $c_id));
	}

// RE-ENROLL
	public function re_enroll($id = null, $c_id = null) {
		$this->Course->Courseenrolment->id = $id; // sets passed value 1 from view as the course related courseenrolment id
		$this->Course->id = $c_id; // sets the 2nd passed value from the view as the id for course

		if (!$this->Course->Courseenrolment->exists()) {
			throw new NotFoundException(__('Invalid enrollment.'));
		}
		$this->request->onlyAllow('post', 'put');
		if ($this->Course->Courseenrolment->save($this->request->data)) {
			$this->Course->Courseenrolment->set('status', 'Enrolled');
			$this->Course->Courseenrolment->save();

			$db =& ConnectionManager::getDataSource($this->Course->useDbConfig);
			$this->Course->set('current_enrolled', $db->expression('`current_enrolled`+1'));
			$this->Course->save();

			$this->Session->setFlash(__('Member re-enrolled.'));
			$this->redirect(array('action' => 'detailedcourse/', $c_id));
		}
		$this->Session->setFlash(__('Enrollment could not be deleted.'));
		$this->redirect(array('action' => 'detailedcourse/', $c_id));
	}

// CANCEL ENROLL
	public function cancel_enroll($id = null, $c_id = null) {
		$this->Course->Courseenrolment->id = $id; // sets passed value 1 from view as the course related courseenrolment id
		$this->Course->id = $c_id; // sets the 2nd passed value from the view as the id for course

		if (!$this->Course->Courseenrolment->exists()) {
			throw new NotFoundException(__('Invalid enrollment.'));
		}
		$this->request->onlyAllow('post', 'put');
		if ($this->Course->Courseenrolment->save($this->request->data)) {
			$this->Course->Courseenrolment->set('status', 'Cancelled');
			$this->Course->Courseenrolment->save();

			$db =& ConnectionManager::getDataSource($this->Course->useDbConfig);
			$this->Course->set('current_enrolled', $db->expression('`current_enrolled`-1'));
			$this->Course->save();

			$this->Session->setFlash(__('Member enrollment has been cancelled.'));
			$this->redirect(array('action' => 'detailedcourse/', $c_id));
		}
		$this->Session->setFlash(__('Enrollment could not be deleted.'));
		$this->redirect(array('action' => 'detailedcourse/', $c_id));
	}
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Course->exists($id)) {
			throw new NotFoundException(__('Invalid course.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Course->save($this->request->data)) {
				$this->Session->setFlash(__('The course has been updated.'));
				$this->redirect(array('action' => 'detailedcourse/'. $id));
			} else {
				$this->Session->setFlash(__('The course could not be saved. Please try again.'));
			}
		} 
		else {
			$options = array('conditions' => array('Course.' . $this->Course->primaryKey => $id));
			$this->request->data = $this->Course->find('first', $options);
		}
		$options = array('conditions' => array('Course.' . $this->Course->primaryKey => $id));
		$this->set('course', $this->Course->find('first', $options));
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
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			throw new NotFoundException(__('Invalid course.'));
		}
		//$this->request->onlyAllow('post', 'delete');
        //Check for all users that are enrolled and active!
        $course = $this->Course->find('first',array(
            'conditions'=>array('Course.id'=>$id),
            'fields'=>array(
                'Course.id',
                'Course.course_code',
                'Course.course_name',
                'Course.courseName'
            ),
            'contain'=>array(
                'Courseenrolment'=>array(
                    'fields'=>array(
                        'Courseenrolment.id',
                        'Courseenrolment.course_id',
                        'Courseenrolment.member_id'
                    ),
                    //Only find the active enrollments
                    'conditions'=>array('Courseenrolment.active'=>1),
                    'Member'
                )
            )
        ));

        foreach($course['Courseenrolment'] as $member) {
            //
            $Email = new CakeEmail('monashSMTP');
            //set template, find the email address of the member
            $Email->template('course_deleted', 'default')
                ->emailFormat('html')
                ->to(array($member['Member']['member_email'])) //email address is set to the member
                ->from(array('no-reply@u3a.org.au'=>'U3A University'))
                ->subject($course['Course']['course_name'].' is no longer offered')
                ->viewVars(array('member' => $member,'course'=>$course['Course']))
                ->send();
        }

		$data = array('id' => $this->Course->id, 'active' => '0');
		// This will update Course with id 10
		$this->Course->save($data);

		$this->Session->setFlash(__('Course has been removed. An email was sent to '.count($course['Courseenrolment']).' member(s).'));
		$this->redirect(array('action' => 'index'));
	}

	public function reactivate($id = null) {
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			throw new NotFoundException(__('Invalid course.'));
		}

		$data = array('id' => $this->Course->id, 'active' => '1');
		// This will update Course with id 10
		$this->Course->save($data);

		$this->Session->setFlash(__('Course was re-activated.'));
		$this->redirect(array('action' => 'detailedcourse/', $this->Course->id));
	}
}
