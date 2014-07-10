<?php
class ServiceUserIdentity extends CUserIdentity
{
	private $_id;

    /**
     * @var EAuthServiceBase the authorization service instance.
     */
    protected $service;

    /**
     * Constructor.
     * @param EAuthServiceBase $service the authorization service instance.
     */
    public function __construct($service) {
        $this->service = $service;
    }

    /**
     * Authenticates a user based on {@link username}.
     * This method is required by {@link IUserIdentity}.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        if ($this->service->isAuthenticated) {
            $this->username = $this->service->getAttribute('name');
            $this->_id=$this->service->id;
            $this->setState('name', $this->username);
            $this->setState('service', $this->service->serviceName);
            $this->errorCode = self::ERROR_NONE;
        }
        else {
            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
        }
        return !$this->errorCode;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId()
    {
    	return $this->_id;
    }

}