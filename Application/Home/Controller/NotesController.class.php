<?php
namespace Home\Controller;

// use Think\Upload;
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
		// first identify login or not

		$upload = new \Think\Upload();// 实例化上传类
    	$upload->maxSize   =     3145728 ;// 设置附件上传大小
    	$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    	$upload->rootPath  =     './Uploads/NotePhotoes/'; // 设置附件上传根目录
    	$upload->savePath  =     ''; // 设置附件上传（子）目录
    	$upload->callback  = 	  true;
    	$upload->autoSub 	= 	false;
    // 上传文件 
    	$info   =   $upload->upload();
    	if(!$info) {// 上传错误提示错误信息
        	// $this->error($upload->getError());
        	$error = $upload->getError();
        	if ($error == "没有文件被上传！") {
        		$photo = NULL;
        	}	else {
        			$this->error($upload->getError);
        	}
    	}else{// 上传成功
	        // $this->success("add photo");
	        $photo = $info['photo']['name'];
    	}

		$bookid_session = getBookid();		
		if (isset($bookid_session)) {
			$bookId = $bookid_session;
		}	else {
				// $_SESSION['bookid'] = 1;
				// $bookId = 1;
				redirect(U('Notes/index'), 0, 'bookid miss, go back to the index');
		}
		// get bookId

		$book = M('books');
		$bookInfo = $book->find($bookId);
		// get book information

		$username = getUsername();
		$data['bookid'] = $bookId;
		$data['username'] = $username;
		$data['chapter'] = I('post.chapter');
		$data['page'] = I('post.page');
		$data['note'] = I('post.note');
		$data['photo'] = $photo;
		$data['public'] = I('post.public');
		$data['create_time'] = NOW_TIME;
		// var_dump($data);
		$noteModel = M('notes');
		$noteModel->add($data);

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


// array(1) { 
// 	["photo"]=> array(9) { 
// 		["name"]=> string(23) "6597270977284987003.jpg" 
// 		["type"]=> string(10) "image/jpeg" 
// 		["size"]=> int(53043) 
// 		["key"]=> string(5) "photo" 
// 		["ext"]=> string(3) "jpg" 
// 		["md5"]=> string(32) "b373b8fc596a8952313d7d346c3752c9" 
// 		["sha1"]=> string(40) "da581a7d1e3bd3ae902885cafcad5f3a06fad54a" 
// 		["savename"]=> string(17) "5584cabadce99.jpg" 
// 		["savepath"]=> string(11) "2015-06-20/" 
// 	} 
// 	}

	public function upload(){
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   =     3145728 ;// 设置附件上传大小
    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    $upload->rootPath  =     './Uploads/NotePhotoes/'; // 设置附件上传根目录
    $upload->savePath  =     ''; // 设置附件上传（子）目录
    $upload->callback  = 	  true;
    $upload->autoSub 	= 	false;
    // 上传文件 
    $info   =   $upload->upload();
    if(!$info) {// 上传错误提示错误信息
        // $this->error($upload->getError());
        // echo $upload->getError();
        if ($upload->getError() == "没有文件被上传！") {
        	$this->assign('error', "oooo");
        }	else {
        		$this->assign('error', $upload->getError());
        }
        $this->display();
    }else{// 上传成功
  //   	foreach($info as $key) 
		// { 
		// 　　echo $key; 
		// } 
		// var_dump($info);
		echo $info['photo']['name'];
		echo "hello";
        // $this->success("add photo");
    }
}



}


