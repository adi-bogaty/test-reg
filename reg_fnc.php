<?php
	$mysqli = false;

	function createDB($db_name) {
		$server = "localhost";
		$username = "root";
		//$password = "";

		$link = mysqli_connect($server, $username);
		if (!$link) {
			die('<p align=center>Невозможно соединиться с сервером базы данных! '.mysql_error().'</p>');
		};

		$dbcreate_query = "CREATE DATABASE ".$db_name;

		if (!mysqli_query($link, $dbcreate_query)) {
			die('<p align=center>Невозможно выполнить запрос! '.mysql_error().'</p>');
		}
		mysqli_close($link);
	}
	function createTable($table_name, $db_name) {
		$server = "localhost";
		$username = "root";
		//$password = "";

		$link = mysqli_connect($server, $username);
		if (!$link) {
			die('<p align=center>Невозможно соединиться с сервером базы данных! '.mysql_error().'<p>');
		};

		if (!mysqli_select_db($link, $db_name)) {
			die('<p align=center>Невозможно выбрать базу данных! '.mysql_error().'<p>');
		}

		$tbCreateQuery = "CREATE TABLE ".$table_name."(
			id INT NOT NULL AUTO_INCREMENT,
			PRIMARY KEY (id),
			name VARCHAR(50),
			email VARCHAR(50),
			password VARCHAR(50)
		)";

		if (!mysqli_query($link, $tbCreateQuery)) {
			die('<p align=center>Невозможно создать таблицу! '.mysql_error().'</p>');
		}

		mysqli_close($link);
	}

	function connectDB($db_name) {
		global $mysqli;
		$mysqli = new mysqli("localhost", "root", "", "$db_name");
		$mysqli->query("SET NAMES 'utf8'");
	}
	function closeDB() {
		global $mysqli;
		$mysqli->close();
	}

	function isDBExist($db_name) {
		$link = mysqli_connect('localhost', 'root', '');
		
		if (!mysqli_select_db($link, $db_name)) {
			return false;
		} else {
			return true;
		}
		/*$db_list = mysqli_list_dbs($link);

		while ($row = mysqli_fetch_object($db_list)) {
			// echo $row->Database."\n";
			if (strcmp($db_name, $row->Database) == 0) {
				//echo "Hooray!";
				return true;
			}
		}

		return false;
		*/
	}

	function addUser($name, $email, $password) {
		global $mysqli;
		connectDB("testreg_db");
		$success = $mysqli->query("INSERT INTO `users` (`name`, `email`, `password`) VALUES ('$name', '$email', '$password')");
		closeDB();
		return $success;
	}

	if (!empty($_POST["btn-reg"])) {
		$uname = htmlspecialchars($_POST["uname"]);
		$email = htmlspecialchars($_POST["email"]);
		$password_0 = htmlspecialchars($_POST["password_0"]);
		$password_1 = htmlspecialchars($_POST["password_1"]);

		if (!isDBExist("testreg_db")) {
			createDB("testreg_db");
			createTable("users", "testreg_db");
		}
		if (strlen($email) < 3) $success = false;
		elseif (strlen($password_0) < 3) $success = false;
		elseif ($password_0 != $password_1) $success = false;
		else $success = addUser($uname, $email, md5($password_0));

?>
		<script>
			// открываем окно хостинга, где хранитс сайт
			// ПРИ СМЕНЕНЕ ХОСТИНГА НАДО ЗДЕСЬ ПОМЕНЯТЬ АДРЕС ССЫЛКИ! (а возможно и id элементов)
			// var winHost = window.open("https://server192.hosting.reg.ru:1500/ispmgr?func=logon", "HostAuth for Admin", "");
			// winHost.onload = function() {

			// 	winHost.getElementById("username").value = "u0532844";
			// 	winHost.getElementById("password").value = "X5k6S1g7V4v7J5d1";
			// 	winHost.getElementById("submit").click();
			
			// 	winHost.close();
			// };

			// открываем на хостинге phpMyAdmin, т. е. д. с. авторизуемся в базе данных
			// ПРИ СМЕНЕНЕ ХОСТИНГА НАДО ЗДЕСЬ ПОМЕНЯТЬ АДРЕС ССЫЛКИ!
			// var winDB = window.open("https://server192.hosting.reg.ru/phpmyadmin/", "DBAuth for Admin", "");
			//winDB.onload = function() {
			//	winDB.getElementById("input_username").value = "u0532844_nerielt";
			//	winDB.getElementById("input_password").value = "O5p4D2o6";
			//	winDB.getElementById("input_go").click();
			
			//	winDB.close();
			//};
		</script>
<?php

		if (!$success) $alert = "Ошибка при регистрации";
		else $alert = "Вы успешно зарегистрировались";
		include "alert.php";
	}

?>
