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
        // Redirect to appropriate dashboard if already authenticated
        if (session()->get('logged_in')) {
            $role = session()->get('role');
            if ($role === 'super_admin') {
                return redirect()->to('/super-admin/dashboard');
            } else {
                return redirect()->to('/admin/dashboard');
            }
        }
        
        return view('auth/login');
    }

    public function superAdminLogin()
    {
        // Redirect to super admin dashboard if already authenticated as super admin
        if (session()->get('logged_in') && session()->get('role') === 'super_admin') {
            return redirect()->to('/super-admin/dashboard');
        }
        
        return view('auth/super_admin_login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->authenticate($username, $password);

        if ($user) {
            // Check if user is trying to login as admin restoran
            if ($user['role'] === 'super_admin') {
                session()->setFlashdata('error', 'Akun Super Admin harus login melalui halaman khusus!');
                return redirect()->back();
            }

            $sessionData = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'restoran_id' => $user['restoran_id'],
                'logged_in' => true
            ];

            session()->set($sessionData);
            return redirect()->to('/admin/dashboard');
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

    public function superAdminLoginProcess()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->authenticate($username, $password);

        if ($user && $user['role'] === 'super_admin') {
            $sessionData = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'restoran_id' => $user['restoran_id'],
                'logged_in' => true
            ];

            session()->set($sessionData);
            return redirect()->to('/super-admin/dashboard');
        } else {
            session()->setFlashdata('error', 'Username atau password salah!');
            return redirect()->back();
        }
    }
} 