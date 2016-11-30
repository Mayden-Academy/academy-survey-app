<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BuilderController extends AbstractActionController
{
    private $user;
    const LOGIN_HEADER = 'Location: /login';

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function indexAction()
    {
        if(!empty($_SESSION['userAuth'])) {
            try {
                $this->user->validateToken($_SESSION['userAuth'], $_SESSION['id']);
                return new ViewModel();
            } catch (Exception $e) {
                session_destroy();
                header(self::LOGIN_HEADER);
                exit;
            }
        } else {
            $header_str = 'Location: /login';
            header(self::LOGIN_HEADER);
            exit;
        }
    }
}
