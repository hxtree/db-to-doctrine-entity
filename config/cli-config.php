<?php


use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/../bootstrap.php';
// ^ contains $entityManager = GetEntityManager();

return ConsoleRunner::createHelperSet($entityManager);
