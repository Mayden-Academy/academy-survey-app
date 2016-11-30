<?php

use Application\Controller\AccountController;
use PHPUnit\Framework\TestCase;
include __DIR__ . '/../../../../vendor/autoload.php';

class AccountControllerTest extends TestCase
{
    public function testSuccessfulCleanData() {
        $loginDetails = ['email' => 'example@email.com', 'password' => 'password'];

        $clean = AccountController::cleanData($loginDetails);

        $this->assertEquals($clean['email'], filter_var('example@email.com', FILTER_SANITIZE_EMAIL));
        $this->assertEquals($clean['password'], filter_var('password', FILTER_SANITIZE_STRING));
    }

    public function testPostContainsAdditionalArrayValuesCleanData() {
        $loginDetails = ['email' => 'example@email.com', 'password' => 'password', 'extra' => 'placeholder'];

        $clean = AccountController::cleanData($loginDetails);

        $this->assertEquals(count($clean), 2);
    }

    public function testMissingEmailCleanData() {
        $loginDetails = ['password' => 'password'];

        try{
            $clean = AccountController::cleanData($loginDetails);
        } catch (Exception $e) {
            $this->assertEquals($e->getMessage(), 'Missing email');
        }
    }

    public function testMissingPasswordCleanData() {
        $loginDetails = ['email' => 'example@email.com'];

        try{
            $clean = AccountController::cleanData($loginDetails);
        } catch (Exception $e) {
            $this->assertEquals($e->getMessage(), 'Missing password');
        }
    }

    public function testMissingEmailAndPasswordCleanData() {
        $loginDetails = ['extra' => 'placeholder'];

        try{
            $clean = AccountController::cleanData($loginDetails);
        } catch (Exception $e) {
            $this->assertEquals($e->getMessage(), '$_POST is missing email and password');
        }
    }

    public function testEmptyPostCleanData() {
        $loginDetails = [];

        try{
            $clean = AccountController::cleanData($loginDetails);
        } catch (Exception $e) {
            $this->assertEquals($e->getMessage(), '$_POST is empty');
        }
    }
}