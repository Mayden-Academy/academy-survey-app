<?php

use Application\Model\UserModel;
use PHPUnit\Framework\TestCase;
include __DIR__ . '/../../../../vendor/autoload.php';

class UserModelTest extends TestCase {

    /**
     * Tests that setUserDetails() returns true when passed valid array
     */
    public function testSetUserDetailsGood(){
        $mockPDO = $this->createMock('PDO');
        $user = new UserModel($mockPDO);
        $userDetails = ['id'=>'1', 'email'=>'example@email.com'];
        $this->assertTrue($user->setUserDetails($userDetails));
    }

    public function testSetUserDetailsBad(){
        $mockPDO = $this->createMock('PDO');
        $user = new UserModel($mockPDO);
        $userDetails = ['email'=>'example@email.com'];
        $this->assertNotTrue($user->setUserDetails($userDetails));
    }

    public function testSetUserDetailsMalformed(){
        $mockPDO = $this->createMock('PDO');
        $user = new UserModel($mockPDO);
        $userDetails = 1;
        try {
            $user->setUserDetails($userDetails);
        } catch (Exception $e) {
            $this->assertEquals('incorrect data type passed, array is required', $e->getMessage());
        }
    }
}