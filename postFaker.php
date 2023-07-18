<?php
ini_set('max_execution_time', '0'); // for infinite time of execution 

require 'vendor/autoload.php';
require "bootstrap.php";

$faker = Faker\Factory::create();

if (!$dbConnection) {
	die("Db connection not created");
}

//1 Million means 10,00,000
$dataDumpLimit = 1000000;

for ($i = 0; $i <= $dataDumpLimit; $i++) {
	$postTitle  = $faker->words(2, true);
	$postBody   = $faker->realText(50);
	$postAuthor = $faker->name;

	$statement = "
		INSERT INTO post
			(title, body, author)
		VALUES
			(:title, :body, :author);
	";

	try {
		$statement = $dbConnection->prepare($statement);
		$statement->execute(array(
			'title' => $postTitle,
			'body'  => $postBody,
			'author' => $postAuthor ?? null,
		));

		echo "New record has id: " . $dbConnection->lastInsertId();
		echo '<br>';
		//return $statement->rowCount();
	} catch (\PDOException $e) {
		exit($e->getMessage());
	}
}
