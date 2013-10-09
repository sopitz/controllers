<?php
require_once '../../interfaces/IEntityManager.php';

// $entityManager = new EntityManager();
$result = IEntityManager::persistPNVData("jl13", "10000001", array("jl13-firstname" => "Simon", "jl13-lastname" => "Opitz"));
print_r($result);


$entities = IEntityManager::getEntitiesfromProjectShortcut("jl13");
foreach ($entities as $entity) {
	echo $entity."<br />";
}