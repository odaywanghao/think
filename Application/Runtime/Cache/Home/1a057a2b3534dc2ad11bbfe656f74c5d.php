<?php if (!defined('THINK_PATH')) exit(); $user = getUsername(); ?>

<head>all notes information</head>
<h1> user </h1>
<table>
	<tr>
		<td>user:</td>
		<td><?php echo ($user); ?></td>
	</tr>
</table>


<h1>login out</h1>
<FORM method="post" action="/yoyoyo/think/index.php/Home/Notes/logout/error/2">
<INPUT type="submit" value="登出">
</FORM>

<h1>my notes about this book</h1>
<FORM method="post" action="/yoyoyo/think/index.php/Home/Notes/myBookNotes">
<INPUT type="submit" value="myBookNotes">
</FORM>


<h1>my all notes</h1>
<FORM method="post" action="/yoyoyo/think/index.php/Home/Notes/myAllNotes">
<INPUT type="submit" value="myAllNotes">
</FORM>


<h1>add a note</h1>
<FORM method="post" action="/yoyoyo/think/index.php/Home/Notes/addNote">
<INPUT type="submit" value="add note">
</FORM>

<h1>all public notes</h1>
<FORM method="post" action="/yoyoyo/think/index.php/Home/Notes/bookAllNotes">
<INPUT type="submit" value="allNotes">
</FORM>


<h1> book name</h1>

<table>
 <tr>
    <td>bookname:</td>
    <td><?php echo ($bookInfo[bookname]); ?></td>
 </tr>
 <tr>
    <td>picture:</td>
    <td><?php echo ($bookInfo[picture]); ?></td>
 </tr>
 </table>


<h1>notes list</h1>
<h2>notesCount:<?php echo ($allNotesCount); ?></h2>
<h2>the first note</h2>
<table>
	<tr>
		<td>id:</td>
		<td><?php echo ($allNotes[0][id]); ?></td>
	</tr>
	<tr>
		<td>bookid:</td>
		<td><?php echo ($allNotes[0][bookid]); ?></td>
	</tr>
	<tr>
		<td>username:</td>
		<td><?php echo ($allNotes[0][username]); ?></td>
	</tr>
	<tr>
		<td>chapter:</td>
		<td><?php echo ($allNotes[0][chapter]); ?></td>
	</tr>
	<tr>
		<td>page:</td>
		<td><?php echo ($allNotes[0][page]); ?></td>
	</tr>
	<tr>
		<td>note:</td>
		<td><?php echo ($allNotes[0][note]); ?></td>
	</tr>
	<tr>
		<td>photo:</td>
		<!-- <td><?php echo ($allNotes[0][note]); ?></td> -->
		<br/>

		<img src = "/yoyoyo/think/Uploads/NotePhotoes/<?php echo ($allNotes[0][photo]); ?>" alt = "yiya" title = "noto photo" />
		<!-- <img src = "/think/Uploads/NotePhotoes/55850203c0c89.jpg" alt = "yiya" title = "noto photo" /> -->

		<br/>
	</tr>
	<tr>
		<td>create_tiem:</td>
		<td><?php echo ($allNotes[0][create_time]); ?></td>
	</tr>
</table>