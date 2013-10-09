<?php
require_once '../../interfaces/IValidator.php';
// $validator = new Validator();
if (!(IValidator::isValid($_POST['data']))) {
	$errors = IValidator::getErrors();
	var_dump($errors);
} else {
	echo "is valid";
}
?>