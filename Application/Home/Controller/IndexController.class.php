<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function index() {
		redirect(U('Comments/comments'), 0, "redirect to comments");
	}


	public function comments($bookId = -1) {
		if ($bookId !=  -1) {
			$_SESSION['bookid'] = $bookId;
		}
		$bookid_session = getBookid();		
		if (isset($bookid_session)) {
			$bookId = $bookid_session;
		}	else {
				$_SESSION['bookid'] = 1;
		}
		if (noLogin()) {
			// redirect(U('Index/login/'), 1, "no login");
			$this->error("未登录", U('Index/login/'), 3);
		}		
		$bookid_session = getBookid();		
		$book = M('books');
		$bookInfo = $book->find($bookId);
		$comments = M('comments');
		$where_sql = "bookid = '$bookId'";
		$commentsList = $comments->where("$where_sql")->order('create_time desc')->select();
		$commentsCount = count($commentsList);
		if ($bookInfo) {
			$this->assign('bookInfo', $bookInfo);
			$this->assign("commentsList", $commentsList);
			$this->assign('commentsCount', $commentsCount);
		}	else {
			redirect(U('Index/comments'), 3, "there isn't this book!");
		}
		$this->display(comments);
	}


	public function dianzan() {
		$zan = D('bookzan');
		if ($zan->create()) {
			$result = $zan->add();
			if ($result) {
				redirect(U('Index/index'), 0, "dianzan success!");
			}	else {
					echo "1111";
					$this->error($zan->getError());
			}
		}	else {
				echo "222222";
				$this->error($zan->getError());
		}
	}

	public function loginout() {
		session('username', null);
		session('bookid', null);
		// redirect(U('Index/login'), 3, "loginout success!");
		redirect(U('Index/index'), 3, "loginout success!");

	}

	public function login() {
		$this->display();
	}
	
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


	public function addComment() {
		$comment = D('comments');
		if ($comment->create()) {
			$result = $comment->add();
			if ($result) {
				$this->success('数据添加成功');
			} else  {
				$this->error('数据添加失败');
			}
		} else 	{
			$this->error($comment->getError());
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


	public function notesList() {
		$username = getUsername();
		$notes = M("notes");
		$notes -> join('__BOOKS__ ON __NOTES__.bookid = __BOOKS__.id') -> select();
		//$notes -> join('notes ON books.id = notes.bookid') -> select();
		$where_sql = "username = '$username'";
		$notesList = $notes -> where ("$where_sql") -> order('create_time desc') -> select();
		$notesCount = count($notesList);
		if ($notesCount) {
			$this->assign("notesList", $notesList);
			$this->assign('notesCount', $notesCount);
		}
		else {
			$this -> error('no notes');
		}

		$this -> display();
	}


}
