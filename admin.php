<?php 
require "_header.php";

if(isset($_POST["submit"])){
	if(isset($_POST["check"])){
		if($db->codeExist($_POST["check"])){
			$message = $_POST["check"]. " existe bel et bien !";
		}else{
			$message = "Ce code n'existe pas !";
		}
	}else{
		$message = "Veuillez compléter le champ";
	}
}

if(isset($_GET["del"])){
	$_GET["del"] = (int) $_GET["del"];
	
	if($_GET["del"] > 0){
		$db->getTrue($_GET["del"]);
		echo "<h1>Le code a bien été utilisé</h1>";
		header("Refresh: 3;URL=admin.php");
		exit;
	}
}

?>
<?php require "header.php"?>
<!--
		<form action="" method="post">
			<label for="checkCode">Vérifier le code promo :</label>
			<input type="text" name="check" id="checkCode">
			<input type="submit" name="submit" value="Vérifier le code">
		</form>
		<?php 
		if(isset($message)):?>
		<p class="checkCode"><?= $message ?></p>
		<?php endif;?>-->

		<ul id="list">
		<?php 
		$list = $db->getList();
		foreach($list as $value):?>
			<li><?= $value->codePromo;?> <br><a class="delete" href="?del=<?= $value->id?>">Supprimer</a></li>
		<?php endforeach;?>
		</ul>
	
<?php require "footer.php";?>