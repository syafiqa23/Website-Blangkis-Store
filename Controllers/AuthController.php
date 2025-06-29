<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use League\OAuth2\Client\Provider\Google;

class AuthController extends BaseController
{
    protected $user;
    protected $google;

    function __construct()
    {
        helper('form');
        $this->user = new UserModel();

        $this->google = new Google([
            'clientId'     => getenv('GOOGLE_CLIENT_ID'),
            'clientSecret' => getenv('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => getenv('GOOGLE_REDIRECT_URI'),
        ]);
    }

    public function googleLogin()
    {
        $authUrl = $this->google->getAuthorizationUrl();
        session()->set('oauth2state', $this->google->getState());
        return redirect()->to($authUrl);
    }

    public function googleCallback()
    {
        $code = $this->request->getGet('code');
        $state = $this->request->getGet('state');

        if (empty($code) || ($state !== session()->get('oauth2state'))) {
            session()->remove('oauth2state');
            return redirect()->to('login')->with('error', 'Login gagal.');
        }

        $token = $this->google->getAccessToken('authorization_code', ['code' => $code]);
        $googleUser = $this->google->getResourceOwner($token);

        $userData = $googleUser->toArray();

        // Lakukan pengecekan user di DB, simpan session login
        session()->set([
            'isLoggedIn' => true,
            'username' => $userData['email'],
            'name' => $userData['name'],
        ]);

        return redirect()->to('/');
    }

    public function login()
    {
        if ($this->request->getPost()) {
            $rules = [
                'username' => 'required|min_length[6]',
                'password' => 'required|min_length[7]|numeric',
            ];

            if ($this->validate($rules)) {
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');

                $dataUser = $this->user->where(['username' => $username])->first(); //pasw 1234567

                if ($dataUser) {
                    if (password_verify($password, $dataUser['password'])) {
                        session()->set([
                            'username' => $dataUser['username'],
                            'role' => $dataUser['role'],
                            'isLoggedIn' => TRUE
                        ]);

                        return redirect()->to(base_url('home'));
                    } else {
                        session()->setFlashdata('failed', 'Kombinasi Username & Password Salah');
                        return redirect()->back();
                    }
                } else {
                    session()->setFlashdata('failed', 'Username Tidak Ditemukan');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('failed', $this->validator->listErrors());
                return redirect()->back();
            }
        }

        return view('v_login');
    }
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('home');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'username' => 'required|min_length[4]|is_unique[user.username]',
                'email' => 'required|valid_email|is_unique[user.email]',
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]'
            ];

            if (!$this->validate($rules)) {
                session()->setFlashdata('failed', $this->validator->listErrors());
                return redirect()->back()->withInput();
            }

            $this->user->save([
                'username' => $this->request->getVar('username'),
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'role' => 'customer',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            return redirect()->to('login')->with('success', 'Registrasi berhasil, silakan login!');
        }

        return view('v_register');
    }



    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}
