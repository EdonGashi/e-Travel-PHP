	<br>
	<div class="komento">
	<form class="form" name="KomentForma" method="post">
	<textarea name="komenti" cols="120" rows="5"></textarea>
	<button type="submit" name="<?php $_GET['id'] ?>">Dergo</button>
	</form>
	</div>
	
<?php
require_once("../resources/config.php");
require_once(databaza);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$repo = new repository();
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['komenti']))
{
    if(!isset($_SESSION['Username']) || !isset($_SESSION['Emri']) || !isset($_SESSION['Mbiemri']))
	{    
        header("Location: http://localhost/login.php");
    }
    else 
	{   
        $komenti = $_POST['komenti'];
        $komentuesi = $_SESSION['Username'];

        $repo->execute_query("Insert Into forumi(ChatID, Komentuesi, Komenti) values (" . $_GET["id"] .",'$komentuesi','$komenti')");
    
	header('Location: /lokacionet.php?id='. $_GET['id']);
	exit;
    }   
}
?>