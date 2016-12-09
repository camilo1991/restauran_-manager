<?php
App::uses('AppController', 'Controller');

class CocinerosController extends AppController {


	public $components = array('Paginator');

	public function index() {
		$this->Cocinero->recursive = 0;
		$this->set('cocineros', $this->Paginator->paginate());
	}


	public function view($id = null) {
		if (!$this->Cocinero->exists($id)) {
			throw new NotFoundException(__('Invalid cocinero'));
		}
		$options = array('conditions' => array('Cocinero.' . $this->Cocinero->primaryKey => $id));
		$this->set('cocinero', $this->Cocinero->find('first', $options));
	}


	public function add() {
		if ($this->request->is('post')) {
			$this->Cocinero->create();
			if ($this->Cocinero->save($this->request->data)) {
				$this->Session->setFlash('The cocinero has been saved.', 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The cocinero could not be saved. Please, try again.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		$platillos = $this->Cocinero->Platillo->find('list');
		$this->set(compact('platillos'));
	}


	public function edit($id = null) {
		if (!$this->Cocinero->exists($id)) {
			throw new NotFoundException(__('Invalid cocinero'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Cocinero->save($this->request->data)) {
				$this->Session->setFlash('The cocinero has been saved.', 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The cocinero could not be saved. Please, try again.', 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Cocinero.' . $this->Cocinero->primaryKey => $id));
			$this->request->data = $this->Cocinero->find('first', $options);
		}
		$platillos = $this->Cocinero->Platillo->find('list');
		$this->set(compact('platillos'));
	}


	public function delete($id = null) {
		$this->Cocinero->id = $id;
		if (!$this->Cocinero->exists()) {
			throw new NotFoundException(__('Invalid cocinero'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Cocinero->delete()) {
			$this->Session->setFlash('The cocinero has been deleted.', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('The cocinero could not be deleted. Please, try again.', 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
