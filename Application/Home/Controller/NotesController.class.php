<?php
namespace Home\Controller;

use Think\Upload;
use Think\Controller;
class NotesController extends Controller {
	public function index() {
		redirect(U('Notes/bookAllNotes'), 0, "go to book's all notes");
	}

	// public function bookInfoHere() {
	// 	$book = M('books');
	// 	$bookInfo = $book->find($bookId);
	// 	return $bookInfo;
	// }

	// public function bookIdHere() {
	// 	$bookid_session = getBookid();		
	// 	if (isset($bookid_session)) {
	// 		$bookId = $bookid_session;
	// 	}	else {
	// 			$_SESSION['bookid'] = 1;
	// 			$bookId = 1;
	// 	}
	// 	return $bookId;
	// }

	public function bookAllNotes() {
		if (noLogin()) {
			redirect(U('User/login', array("error" => 3)), 0, "go to login");
		}
		$bookid_session = getBookid();		
		if (isset($bookid_session)) {
			$bookId = $bookid_session;
		}	else {
				$_SESSION['bookid'] = 1;
				$bookId = 1;
		}
		// get bookId

		$book = M('books');
		$bookInfo = $book->find($bookId);
		// get book information

		$bookAllNotes = M('notes');
		$book_all_users_notes_public = "bookid = '$bookId' and public = 1";
		$allNotes = $bookAllNotes->where("$book_all_users_notes_public")->order('create_time desc')->select();
		$allNotesCount = count($allNotes);
		$this->assign('allNotes', $allNotes);
		$this->assign('bookInfo', $bookInfo);
		$this->assign('allNotesCount', $allNotesCount);
		$this->display();

	}

	public function myBookNotes()  {
		if (noLogin()) {
			redirect(U('User/login', array("error" => 3)), 0, "go to login");
		}
		$bookid_session = getBookid();		
		if (isset($bookid_session)) {
			$bookId = $bookid_session;
		}	else {
				$_SESSION['bookid'] = 1;
				$bookId = 1;
		}
		// get bookId


		$username = getUsername();
		$book = M('books');
		$bookInfo = $book->find($bookId);
		// get book information

		$bookAllNotes = M('notes');
		$book_all_users_notes_public = "bookid = '$bookId' and username = '$username'";
		$allNotes = $bookAllNotes->where("$book_all_users_notes_public")->order('create_time desc')->select();
		$allNotesCount = count($allNotes);
		$this->assign('allNotes', $allNotes);
		$this->assign('bookInfo', $bookInfo);
		$this->assign('allNotesCount', $allNotesCount);
		$this->display();

	}

	public function myAllNotes()  {
		$username = getUsername();
		$book = M('books');
		$bookInfo = $book->find($bookId);
		// get book information

		$bookAllNotes = M('notes');
		$book_all_users_notes_public = "username = '$username'";
		$allNotes = $bookAllNotes->where("$book_all_users_notes_public")->order('create_time desc')->select();
		$allNotesCount = count($allNotes);
		$this->assign('allNotes', $allNotes);
		$this->assign('bookInfo', $bookInfo);
		$this->assign('allNotesCount', $allNotesCount);
		$this->display();
	}

	public function addNote() {
		$this->display();		
	}

	public function addNoteIn() {
		if (noLogin()) {
			redirect(U('User/login', array("error" => 3)), 0, "go to login");
		}
		$bookid_session = getBookid();		
		if (isset($bookid_session)) {
			$bookId = $bookid_session;
		}	else {
				$_SESSION['bookid'] = 1;
				$bookId = 1;
		}
		// get bookId

		$book = M('books');
		$bookInfo = $book->find($bookId);
		// get book information

		$username = getUsername();
		$note = D('notes');
		if ($note->create()) {
			$result = $note->add();
			if ($result) {
				// $this->success('数据添加成功');
				redirect(U("Notes/index"), 0, "add comments success");
				echo "nihao";
			} else  {
				$this->error('数据添加失败');
			}
		} else 	{
			$this->error($note->getError());
		}

	}

	public function editNote() {
		$bookId = bookIdHere();
		$bookInfo = bookInfoHere();
		$username = getUsernme();
		$note = D('notes');
		if ($note->create()) {
			$result = $note->add();
			if ($result) {
				// $this->success('数据添加成功');
				redirect(U("Notes/index"), 0, "add comments success");
			} else  {
				$this->error('数据添加失败');
			}
		} else 	{
			$this->error($note->getError());
		}

	}


	public function logout() {
		redirect(U("User/logout"), 0, "log out");
	}


	public function upload(){
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   =     3145728 ;// 设置附件上传大小
    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
    $upload->savePath  =     ''; // 设置附件上传（子）目录
    // 上传文件 
    $info   =   $upload->upload();
    if(!$info) {// 上传错误提示错误信息
        $this->error($upload->getError());
    }else{// 上传成功
        $this->success('上传成功！');
    }
}



}


