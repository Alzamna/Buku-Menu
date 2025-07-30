<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Redirect to login if not authenticated
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        
        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->authenticate($username, $password);

        if ($user) {
            $sessionData = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'restoran_id' => $user['restoran_id'],
                'logged_in' => true
            ];

            session()->set($sessionData);

            if ($user['role'] === 'super_admin') {
                return redirect()->to('/super-admin/dashboard');
            } else {
                return redirect()->to('/admin/dashboard');
            }
        } else {
            session()->setFlashdata('error', 'Username atau password salah!');
            return redirect()->back();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
} 