<?php if (!defined('THINK_PATH')) exit();?><h1>all public notes</h1>
<FORM method="post" action="/yoyoyo/think/index.php/Home/Notes/bookAllNotes">
<INPUT type="submit" value="allNotes">
</FORM>



 <h1>add note</h1>
<FORM method="post" action="/yoyoyo/think/index.php/Home/Notes/addNoteIn" enctype="multipart/form-data">
chapter：<INPUT type="text" name="chapter"><br/>
page：<INPUT type="text" name="page"><br/>
<textarea name = 'note' id = 'note' cols="60" rows="10">添加新评论...</textarea>
<br/>
<label>public:</label>
    <label>所有人可见</label>
    <input type="radio" value="1"  name="public" />
    <label>仅自己可见</label>
    <input type="radio" value="0"  name="public" />


<br/>
<input type="file" name="photo" />add photo

<br/>
<INPUT type="submit" value="提交">
</FORM>