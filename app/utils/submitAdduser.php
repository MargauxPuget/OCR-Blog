<h1>Message bien reçu en POST et échappé pour le protéger!</h1>
        
<?php
$postData = $_POST;

if (
  !isset($postData['email'])
  || !filter_var($postData['email'], FILTER_VALIDATE_EMAIL)
  || empty($postData['message'])
  || trim($postData['message']) === ''
) {
	echo('Il faut un email et un message valide pour soumettre le formulaire.');
    return;
}
?>
<div class="card">
    
    <div class="card-body">
        <h5 class="card-title">Rappel de vos informations</h5>
        <p class="card-text"><b>Email</b> : <?php echo (htmlspecialchars($postData['email'])); ?></p>
        <p class="card-text"><b>Message</b> : <?php echo (strip_tags($postData['message'])); ?></p>
    </div>
</div>


