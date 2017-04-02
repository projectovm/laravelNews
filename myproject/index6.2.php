<?php 
//Подключение базы данных


// Добавление новых данных в БД (в виде переменных)

	


	// ORDER BY data';  // сортировка по data
    //$sql = 'SELECT rubrika, article_name, data, image, article_text FROM articles
 
/*
//Задание рубрики статьи
//Добавление заголовка статьи
//Добавление текста статьи
if(isset($_POST["go"])){
	//if (isset($_POST['theme']) && isset($_POST['title']) && isset($_POST['message'])) {
	if (isset($_POST['theme'])) {
	$theme = $_POST['theme'];
	}
}
/*
if(isset($_POST["go"])){	
	if(empty($theme)){
	   echo "Заполните строки !";
	}
}

if(isset($_POST["go"])){	
	if (isset($_POST['title'])) {
	$title = $_POST['title'];
	}
}
if(isset($_POST["go"])){	
	if (isset($_POST['message'])) {
	$message = $_POST['message'];
	}
}
*/
// Добавление даты публикации
function GetFullNowDateInCity($timezoneInCity){
		$FullNowDateInCity = date('d.m.Y H:i', (time()+$timezoneInCity*60*60));
	return $FullNowDateInCity;
}

//Добавление картинки
if(isset($_POST["go"])){
	$uploaddir = 'images/';
	// это папка, в которую будет загружаться картинка
	$apend=date('YmdHis').rand(100,1000).'.jpg'; 
	// это имя, которое будет присвоенно изображению 
	$uploadfile = "$uploaddir$apend"; 
	//в переменную $uploadfile будет входить папка и имя изображения
	// проверяем загружается ли изображение 
	// проверяем продходит ли изображение по размеру и формату. Разрешенный размер - до 512 Кб
	//Допустимые форматы jpg, jpeg, png
	if(($_FILES['userfile']['type'] == 'image/gif' || $_FILES['userfile']['type'] == 'image/jpeg' || $_FILES['userfile']['type'] == 'image/png') && ($_FILES['userfile']['size'] != 0 and $_FILES['userfile']['size']<=512000)) { 
	// Указываем максимальный размер загружаемого файла. Сейчас до 512 Кб 
	  	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) { //eсли файл действительно загружен на 
            //сервер, он будет перемещён в место, указанное в $uploadfile
		   //идет процесс загрузки изображения 
		   $size = getimagesize($uploadfile); 
		   // получаем размер пикселей изображения 
		   if ($size[0] < 501 && $size[1]<1501) { 
		     // если размер изображения не более 500 пикселей по ширине и не более 1500 по  высоте 
		     //echo "Файл загружен. Путь к файлу: <b>http://myproject.local/".$uploadfile."</b>"; 
		    } else {
	     		unlink($uploadfile); 
	     		// удаление файла 
	     	} 
	   	} 
	}
} 

?>
<html>
	<head>
	  <link href="style/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	  <link href="style/style.css" rel="stylesheet" type="text/css"/>
	  <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
	  <script type="text/javascript" src="js/bootstrap.min.js"></script>
	   <meta name="viewport" content="width=device-width, initial-scale = 1.0">
	   <link type="text/css" rel="stylesheet" href="style/bootstrap-responsive.css">
	</head>
	<body>
	<div class="row-fluid" id="header">
		<div class="span12" id="box12">
			<h1>News line</h1>
		</div>
	</div>

	<div class="container-fluid">
	<div class="row-fluid">
	    <div class="span2" id="box4" id="menu"> 
			<ul>
				<li><a href="#">Россия</a></li>
				<li><a href="#">Мир</a></li>
				<ul class="sub-menu">
					<li><a href="#">Политика</a></li>
					<li><a href="#">Общество</a></li>
					<li><a href="#">Выборы</a></li>
				</ul>
				<li><a href="#">Экономика</a></li>
				<li><a href="#">Наука</a></li>
				<li><a href="#">Культура</a></li>
				<li><a href="#">Спорт</a></li>
				<li><a href="#">Путешествия</a></li>
			</ul>
		</div>

		<div class="span10" id="box8">

			<div>
				<h1>Your news line</h1>
			</div>

			<div>
			    
			   	<form method="POST" ENCTYPE="multipart/form-data">
			   	  Выберите название рубрики: 
			   	  <SELECT name = "theme">
						<OPTION value = "Россия">Россия
						<OPTION value = "Мир">Мир
						<OPTION value = "Экономика">Экономика
						<OPTION value = "Наука">Наука
						<OPTION value = "Культура">Культура
						<OPTION value = "Спорт">Спорт
						<OPTION value = "Путешествия">Путешествия
				  </SELECT>
			   	  <br>
			   	  Введите название статьи (объемом до 150 знаков): 
			   	  <input type="text" name="title" size="152" maxlength="150" value=""> 
			   	  <br>
			      Введите текст статьи (объемом до 7000 знаков):  <br>
			      <textarea name="message" rows="10" cols="50" maxlength="7000" value=""></textarea>
			      <br>
			      Выберите картинку для загрузки: 
				  <input type="file" name="userfile">
				   <br>
				  <input type="submit" name="go" value="загрузить на сервер">
			    </form>
			</div>
			<div>
<?php			
$dns = 'mysql:host=localhost; dbname=news';
$user = 'news'; 
$pass = 'password';
$basa = new PDO($dns, $user, $pass);

$sql="INSERT INTO articles(rubrika, article_name, image, article_text) VALUES (?, ?, ?, ?)";
	$prep = $basa->prepare($sql);
	$prep->execute([$_POST['theme'],$_POST['title'], $_POST['userfile'], $_POST['message']]);
?>
<?php		$sql2 = 'SELECT * FROM articles'; 	?>
<?php if (isset($_POST['go'])): ?>
	<?php if (isset($_POST['theme']) && isset($_POST['title']) && isset($_POST['message'])): ?>
				<?php foreach ($basa->query($sql2) as $row): ?>
					<?php echo "<br>"; ?>
				    <h2>
				    	<?php echo $row['rubrika'] . "<br>"; ?>
				    </h2>
				    <h2>
				    	<?php echo $row['article_name'] . "<br>";?>
				    </h2>
				    <?php echo $row['data'] . "<br>"; ?>
				    <img src="<?php $row['image'] ?>"> 
				    <?php echo "<br>"; ?>
					<?php echo $row['article_text'] . "<br>"; ?>
				    <?php echo "<br>"; ?>
				<?php endforeach; ?>
	<?php endif; ?>
<?php endif; ?>

			</div>
		</div>

	</div>
  	</div>

	<div class="row-fluid" id="footer">
		<div class="span12" id="box12">
			Project 2017
		</div>
	</div>

	</body>
</html>


