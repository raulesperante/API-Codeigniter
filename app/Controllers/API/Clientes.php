<?php

namespace App\Controllers\API;

use App\Models\ClienteModel;
use CodeIgniter\RESTful\ResourceController;

class Clientes extends ResourceController
{

	public function __construct()
	{
		$this->model = $this->setModel(new ClienteModel());
		
	}

	public function index()
	{
		$clientes = $this->model->findAll();
		return $this->respond($clientes);
	}

	public function create()
	{
		try{
			$cliente = $this->request->getJSON();
			if($this->model->insert($cliente)):
				$cliente->id = $this->model->insertID();
				return $this->respondCreated($cliente);
			else:
				return $this->failValidationErrors($this->model->validation->listErrors());
			endif;
		}catch(\Exception $e){
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}

	public function edit($id = null){
		try {
			if($id == null){
				return $this->failValidationErrors('No se ha pasado un Id válido');
			}
			$cliente = $this->model->find($id);
			if($cliente == null){
				return $this->failValidationErrors('No se ha encontrado un cliente con el id: ' . $id);
			}
			return $this->respond($cliente);
		} catch (\Exception $e) {
			return $this->failValidationErrors('Error del servidor');
		}
	}

	public function update($id = null){
		try {
			if($id == null){
				return $this->failValidationErrors('No se ha pasado un Id válido');
			}
			$clienteVerificado = $this->model->find($id);
			if($clienteVerificado == null){
				return $this->failValidationErrors('No se ha encontrado un cliente con el id: ' . $id);
			}
			$cliente = $this->request->getJSON();
			if($this->model->update($id, $cliente)){
				$cliente->id = $id;
				return $this->respondUpdated($cliente);
			}else{
				return $this->failValidationErrors($this->model->validation->listErrors());
			}

		} catch (\Exception $e) {
			return $this->failValidationErrors('Error del servidor');
		}
	}

	public function delete($id = null){
		try {
			if($id == null){
				return $this->failValidationErrors('No se ha pasado un Id válido');
			}
			$clienteVerificado = $this->model->find($id);
			if($clienteVerificado == null){
				return $this->failValidationErrors('No se ha encontrado un cliente con el id: ' . $id);
			}
			if($this->model->delete($id)){
				return $this->respondDeleted($clienteVerificado);
			}else{
				return $this->failServerError('Ha se ha podido eliminar el registro');
			}
		} catch (\Exception $e) {
			return $this->failValidationErrors('Ha ocurrido un error en el servido');
		}
	}




	
}

