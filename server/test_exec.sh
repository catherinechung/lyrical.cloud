#! /bin/bash

echo "Begin Testing and Report Generation"

php phpunit.phar --bootstrap src/CacheManager.php tests/CacheManagerTests > cache_manager_report.txt
echo "Completed Cache Manager Report Generation"

php phpunit.phar --bootstrap src/APIManager.php tests/APIManagerTests > api_manager_report.txt
echo "Completed API Manager Report Generation"

echo "End Testing and Report Generation"