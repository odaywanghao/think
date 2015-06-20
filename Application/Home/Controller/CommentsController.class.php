<?php
namespace Home\Controller;
use Think\Controller;
class CommentsController extends Controller {
	
	public function index() {
		redirect(U('Comments/comments'), 0, "redirect to comments");
		// redirect(U('Index/comments'), 0, "redirect to comments");
		// echo "hello world";
	}

	public function gotoNotes() {
		redirect(U('Notes/index'), 0, "go to notes");
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
				$bookId = 1;
		}
		// if (noLogin()) {
		// 	// redirect(U('Index/login/'), 1, "no login");
		// 	$this->error("未登录", U('Index/login/'), 3);
		// }		
		// $bookid_session = getBookid();		
		$username_session = getUsername();
		$book = M('books');
		$bookInfo = $book->find($bookId);
		$comments = M('comments');
		$comments_match_bookid_sql = "bookid = '$bookId'";
		$commentsList = $comments->where("$comments_match_bookid_sql")->order('create_time desc')->select();
		$commentsCount = count($commentsList);
		$bookzan = M('bookzan');
		$bookzan_count_where_sql = "bookid = '$bookId'";
		$bookzanCount = $bookzan->where("$bookzan_count_where_sql")->count();
		$bookzan_user_where_sql = "username = '$username_session'";
		$userBookzanCount = $bookzan->where("$bookzan_user_where_sql")->count();

		if (noLogin()) {
			$username_session = "未登录";
			$userDianzan = 0;
		}	
		if ($bookInfo) {
			$this->assign('bookInfo', $bookInfo);
			$this->assign('username', $username_session);
			$this->assign("commentsList", $commentsList);
			$this->assign('commentsCount', $commentsCount);
			$this->assign('bookzanCount', $bookzanCount);
			$this->assign('userDianzan', $userBookzanCount);

		}	else {
			redirect(U('Comments/comments'), 3, "there isn't this book!");
		}
		$this->display(comments);
	}


	public function dianzan($dian = 0) {
		if (noLogin()) {
			redirect(U('User/login', array("error" => 1)), 0, "go to login");
		}

		if ($dian == 1) {
			// echo "dianle";
			$zan = M('bookzan');
			$bookid = getBookid();
			$username = getUsername();
			$del_zan_sql = "bookid = '$bookid' and username = '$username'";
			$zan->where("$del_zan_sql")->delete();
		}	else {
				$zan = D('bookzan');
				$bookzan = getBookzan();
				$zan -> create($bookzan, 3);
				$zan -> add();
		}
		redirect(U('Comments/comments'), 0, "dianzan success!");
	}

	public function addComment() {
		if (noLogin()) {
			redirect(U('User/login', array('error' => 2)), 0, "go to login");
		}
		$comment = D('comments');
		if ($comment->create()) {
			$result = $comment->add();
			if ($result) {
				// $this->success('数据添加成功');
				redirect(U("Comments/comments"), 0, "add comments success");
			} else  {
				$this->error('数据添加失败');
			}
		} else 	{
			$this->error($comment->getError());
		}
	}


	public function logout($error = 0) {
		redirect(U("User/logout", array('error' => $error)), 0, "log out");
	}

	public function goNote() {
		redirect(U("Notes/index"), 0, "go notes");
	}

}

