<?php 
require "_header.php";
require "./phpqrcode/qrlib.php";

$db = new Db();
$userIp = $_SERVER["REMOTE_ADDR"];

$user = new User(["ip" => $userIp]); 

if(!$db->userExist($user->getIp())){
	$codePromo = $user->generateCode();
	
	if($db->codeExist($codePromo)){
		$codePromo = $user->generateCode();
	}
	$user->setCodePromo($codePromo);
	$db->add($user);
	QRcode::png("http://192.168.1.15/admin.php?del=".$user->getId(),"qrcode/".$codePromo.".png",0,3);
	//QRcode::png("blue","qrcode/".$codePromo.".png",0,4);
}
else{
	$connected = true;
	$user = $db->get($user->getIp());
	$codePromo = $user->getCodePromo();
}
 ob_start();
?>
<?php require "header.php";?>
		<div id="affiche">
			<div id="header-affiche">
				<p class="bleu">Le plaisir du Bio</p>
				<p><img src="images/logo-bio3.png"></p>
			</div>

			<div id="logo"><img src="images/logo-sweety2.png"></div>

			<p id="promo" class="bleu">Promo -20%*</p>
			<p>sur votre prochain achat<br> chez SO SWEETY</p>
			
			<?php 
			if(isset($connected) && $connected === true):?>
			<p class="codePromoExist bleu">Vous vous êtes déjà connecté ! Votre QRcode : <br><img src="qrcode/<?= $codePromo. '.png' ?>"></p>
			
			
			<?php else:?>
			<p class="codePromo bleu"><img src="qrcode/<?= $codePromo. '.png' ?>"></p>
			<?php endif;?>

			<p id="condition">*promotion à usage unique et non cumulable avec d'autres promotions en cours</p>
		</div>

<?php require "footer.php";?>