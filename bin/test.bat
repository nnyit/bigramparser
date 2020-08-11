@echo off
SET dir_server=C:\xampp

SET php_exe=%dir_server%\php\php.exe
SET dir_vendor=%dir_server%\vendor\vendor

SET exe_phpunit=%dir_vendor%\phpunit\phpunit\phpunit
SET exe_phpcs=%dir_vendor%\squizlabs\php_codesniffer\bin\phpcs

SET dir_project=%dir_server%\htdocs\dev.achristiansen.com\BigramParser
SET dir_project_tests=%dir_project%\tests\


SET run_test=%php_exe% %exe_phpunit% %dir_project_tests%

SET path_phpcs_ruleset=%dir_project%\config\ruleset.xml
SET run_phpcs=%exe_phpcs% --standard=%path_phpcs_ruleset% %dir_project%\src -s

echo %run_test%
 %run_test%

echo %run_phpcs%
 %run_phpcs%

