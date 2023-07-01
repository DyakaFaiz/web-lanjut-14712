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

        $enkrip = $this->request->getPost('password');
        $md5 = md5($enkrip);

        if (!$errors) {
            $dataForm = [
                'username' => $this->request->getPost('username'),
                'role' => $this->request->getPost('role'),
                'password' => $md5,
                'is_aktif' => isset($_POST['is_aktif'])
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

        $enkrip = $this->request->getPost('password');
        $md5 = md5($enkrip);


        if (!$errors) {
            $dataForm = [
                'username' => $this->request->getPost('username'),
                'role' => $this->request->getPost('role'),
                'password' => $md5,
                'is_aktif' => isset($_POST['is_aktif'])
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
