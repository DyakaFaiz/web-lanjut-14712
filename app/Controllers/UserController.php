<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $user;

    function __construct()
    {
        helper('form');
        $this->validation = \Config\Services::validation();
        $this->user = new UserModel();
    }

    public function index()
    {
        $data['users'] = $this->user->findAll();
        return view('pages/manageUser_view', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $validate = $this->validation->run($data, 'user');
        $errors = $this->validation->getErrors();

        if (!$errors) {
            $dataForm = [
                'username' => $this->request->getPost('username'),
                'role' => $this->request->getPost('role'),
                'password' => $this->request->getPost('password'),
                'is_aktif' => $this->request->getPost('is_aktif')
            ];

            $this->user->insert($dataForm);

            return redirect('user')->with('success', 'Data Berhasil Ditambah');
        } else {
            return redirect('user')->with('failed', implode("<br>", $errors));
        }
    }

    public function edit($id)
    {
        $data = $this->request->getPost();
        $validate = $this->validation->run($data, 'user');
        $errors = $this->validation->getErrors();

        if (!$errors) {
            $dataForm = [
                'username' => $this->request->getPost('username'),
                'role' => $this->request->getPost('role'),
                'password' => $this->request->getPost('password'),
                'is_aktif' => $this->request->getPost('is_aktif')
            ];

            $this->user->update($id, $dataForm);

            return redirect('user')->with('success', 'Data Berhasil Diubah');
        } else {
            return redirect('user')->with('failed', implode("", $errors));
        }
    }

    public function delete($id)
    {
        $dataProduk = $this->user->find($id);

        $this->user->delete($id);

        return redirect('user')->with('success', 'Data Berhasil Dihapus');
    }
}
