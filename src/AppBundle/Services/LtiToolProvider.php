<?php

namespace AppBundle\Services;

use FOS\UserBundle\Doctrine\UserManager;
use IMSGlobal\LTI\ToolProvider;
use IMSGlobal\LTI\ToolProvider\DataConnector;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Since this app is used as a lti tool provider, this service offers lti integration
 * @see https://www.edu-apps.org/code.html
 * @see https://github.com/IMSGlobal/LTI-Tool-Provider-Library-PHP
 * @see https://github.com/IMSGlobal/LTI-Tool-Provider-Library-PHP/wiki
 * Class LtiToolProvider
 * @package AppBundle\Services
 */
class LtiToolProvider extends ToolProvider\ToolProvider
{
    private $userManager;
    private $tokenStorage;
    private $session;
    private $eventDispatcher;
    private $request;

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function __construct(UserManager $userManager, TokenStorage $tokenStorage, Session $session, TraceableEventDispatcher $eventDispatcher)
    {

        $dsn = sprintf('%s:host=%s;dbname=%s', getenv('DB_TYPE'), getenv('DB_HOST'), getenv('DB_NAME'));
        $db = new \PDO($dsn, getenv('DB_USER'), getenv('DB_PWD'));
        $dataConnector = DataConnector\DataConnector::getDataConnector('', $db);
        parent::__construct($dataConnector);
        $this->userManager = $userManager;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->eventDispatcher = $eventDispatcher;
    }

    //todo: role mapping between e-media and LMS
    function onLaunch()
    {
        if (!$userName = $_POST['user_id']) {
            return false;
        }
        if (!$user = $this->userManager->findUserByUsername($userName)) {
            $user = $this->userManager->createUser();
            $user->setFirstName($_POST['lis_person_name_given']);
            $user->setLastName($_POST['lis_person_name_family']);
            $user->setUsername($userName);
            $user->setEmail($_POST['lis_person_contact_email_primary']);
            $user->setPlainPassword($userName);
            $user->setEnabled(true);
            $this->userManager->updateUser($user);
        }
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);
        $this->session->set('_security_main', serialize($token));
        // Fire the login event manually
        $event = new InteractiveLoginEvent($this->getRequest(), $token);
        $this->eventDispatcher->dispatch("security.interactive_login", $event);


        return $user;
    }
    // Insert code here to handle incoming launches - use the user, context
    // and resourceLink properties to access the current user, context and resource link.


    function onContentItem()
    {
        die(__FUNCTION__);

        // Insert code here to handle incoming content-item requests - use the user and context
        // properties to access the current user and context.

    }

    function onRegister()
    {
        die(__FUNCTION__);

        // Insert code here to handle incoming registration requests - use the user
        // property of the $tool_provider parameter to access the current user.

    }

    function onError()
    {
        throw new AccessDeniedException();
        // Insert code here to handle errors on incoming connections - do not expect
        // the user, context and resourceLink properties to be populated but check the reason
        // property for the cause of the error.  Return TRUE if the error was fully
        // handled by this method.

    }

}