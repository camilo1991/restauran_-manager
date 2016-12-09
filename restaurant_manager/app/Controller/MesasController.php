<?php
App::uses('AppController', 'Controller');

class MesasController extends AppController {


	public $components = array('Paginator');


	public function index() {
		$this->Mesa->recursive = 0;
		$this->Paginator->settings = array('limit' => 5);
		$this->set('mesas', $this->Paginator->paginate());
	}


	public function view($id = null) {
		if (!$this->Mesa->exists($id)) {
			throw new NotFoundException(__('Invalid mesa'));
		}
		$options = array('conditions' => array('Mesa.' . $this->Mesa->primaryKey => $id));
		$this->set('mesa', $this->Mesa->find('first', $options));
	}


	public function add() {
		if ($this->request->is('post')) {
			$this->Mesa->create();
			if ($this->Mesa->save($this->request->data)) {
				$this->Session->setFlash('The mesa has been saved.', 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The mesa could not be saved. Please, try again.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		$meseros = $this->Mesa->Mesero->find('list');
		$this->set(compact('meseros'));
	}


	public function edit($id = null) {
		if (!$this->Mesa->exists($id)) {
			throw new NotFoundException(__('Invalid mesa'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Mesa->save($this->request->data)) {
				$this->Session->setFlash('The mesa has been saved.', 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The mesa could not be saved. Please, try again.', 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Mesa.' . $this->Mesa->primaryKey => $id));
			$this->request->data = $this->Mesa->find('first', $options);
		}
		$meseros = $this->Mesa->Mesero->find('list');
		$this->set(compact('meseros'));
	}


	public function delete($id = null) {
		$this->Mesa->id = $id;
		if (!$this->Mesa->exists()) {
			throw new NotFoundException(__('Invalid mesa'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Mesa->delete()) {
			$this->Session->setFlash('The mesa has been deleted.', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('The mesa could not be deleted. Please, try again.', 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
