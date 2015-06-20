<?php if (!defined('THINK_PATH')) exit();?><h1>error:<?php echo ($error); ?></h1>

<h1>登录</h1>

<FORM method="post" action="/yoyoyo/think/index.php/Home/User/loginin/<?php echo ($gogo); ?>">
用户名：<INPUT type="text" name="username"><br/>
密码：<INPUT type="text" name="password"><br/>
<INPUT type="submit" value="登录">
</FORM>



<h1>注册</h1>
<FORM method="post" action="/yoyoyo/think/index.php/Home/User/register">
<INPUT type="submit" value="注册">
</FORM>