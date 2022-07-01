<?php
	include "reg_fnc.php";
?>

<!-- <h2>Регистрация</h2> -->
<form name="reg" action="" method="post" class="reg-form">
	<table>
		<tr>
			<td>Имя:</td>
			<td><input type="text" name="uname" required/></td>
		</tr>
		<tr>
			<td>E-mail:</td>
			<td><input type="text" name="email" required/></td>
		</tr>
		<tr>
			<td>Пароль:</td>
			<td><input type="password" name="password_0" required/></td>
		</tr>
		<tr>
			<td>Повторите пароль:</td>
			<td><input type="password" name="password_1" required/></td>
		</tr>
		<tr>
			<td colspan="2" class="td-form-btn">
				<input type="submit" name="btn-reg" value="Зарегистрироваться" class="btn btn-green">
			</td>
		</tr>
	</table>
</form>