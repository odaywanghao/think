<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
	public function index() {
		redirect(U('Comments/comments'), 0, "redirect to comments");
		// echo "hello world";
	}

	public function logout() {
		session('username', null);
		session('bookid', null);
		// redirect(U('Index/login'), 3, "loginout success!");
		redirect(U('User/index'), 0, "loginout success!");

	}

	public function login($error = 0) {
		$this->assign('error', $error);
		// 0  --- no error
		// 1  --- dian zan
		// 2  --- add comment  
		// 3  --- add note
		$this->display();
	}

	// public function login() 	{
	// 	$this->display();
	// }	
	public function register() {
		$this->display();
	}


	public function addUsers() {
		$user = D('users');
		if ($user->create()) {
			$result = $user->add();
			if ($result) {
				$this->success('注册成功', 'login');
			} else  {
				$this->error($user->getError());
			}
		} else 	{

			$this->error($user->getError());
		}
	}


	public function loginin() {
		$username = I('post.username');
		$password = I('post.password');
		$uu = (string)$username;
		$pp = (string)$password;
		$user = M('users');
		$sql = "username = '$uu' and password = '$pp'";
		$data2 = $user->where("$sql")->find();
		if ($data2) {
			$_SESSION['username'] = $uu;
			redirect(U('Index/index'), 0);
		}	else {
				// echo "login fail";
				$this->error("您的用户名和密码不匹配");
		}
	}


}

