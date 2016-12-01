<?php

use Application\Controller\AccountController;
use PHPUnit\Framework\TestCase;
include __DIR__ . '/../../../../vendor/autoload.php';

class AccountControllerTest extends TestCase
{
    public function testCleanDataAlreadyCleanGood() {
        $loginDetails = ['email' => 'example@email.com', 'password' => 'password'];

        $clean = AccountController::cleanData($loginDetails);

        $this->assertEquals($clean, $loginDetails);
    }

    public function testCleanDataDirtyDataGood() {
        $loginDetails = ['email' => 'exa(mple)@em//ail.com', 'password' => '<p>password</p>'];

        $clean = AccountController::cleanData($loginDetails);

        $this->assertEquals($clean, ['email' => 'example@email.com', 'password' => 'password']);
    }

    public function testCleanDataPostContainsAdditionalArrayValuesGood() {
        $loginDetails = ['email' => 'example@email.com', 'password' => 'password', 'extra' => 'placeholder'];

        $clean = AccountController::cleanData($loginDetails);

        $this->assertArrayHasKey('email', $clean);
        $this->assertArrayHasKey('password', $clean);
    }

    public function testCleanDataMissingEmailBad() {
        $loginDetails = ['password' => 'password'];

        try{
            $clean = AccountController::cleanData($loginDetails);
        } catch (Exception $e) {
            $this->assertEquals($e->getMessage(), 'Missing email');
        }
    }

    public function testCleanDataMissingPasswordBad() {
        $loginDetails = ['email' => 'example@email.com'];

        try{
            $clean = AccountController::cleanData($loginDetails);
        } catch (Exception $e) {
            $this->assertEquals($e->getMessage(), 'Missing password');
        }
    }

    public function testCleanDataMissingEmailAndPasswordBad() {
        $loginDetails = ['extra' => 'placeholder'];

        try{
            $clean = AccountController::cleanData($loginDetails);
        } catch (Exception $e) {
            $this->assertEquals($e->getMessage(), '$_POST is missing email and password');
        }
    }

    public function testCleanDataEmptyPostBad() {
        $loginDetails = [];

        try{
            $clean = AccountController::cleanData($loginDetails);
        } catch (Exception $e) {
            $this->assertEquals($e->getMessage(), '$_POST is empty');
        }
    }

    public function testCleanDataMalformed() {
        $loginDetails = 1;

        try{
            $clean = AccountController::cleanData($loginDetails);
        } catch (Exception $e) {
            $this->assertEquals($e->getMessage(), 'Incorrect data type, expecting array');
        }
    }
}