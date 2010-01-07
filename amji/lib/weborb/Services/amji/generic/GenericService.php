<?php
class GenericService{

	protected $context = null;

	public function __construct()
	{
		require_once dirname(__FILE__).'/../../../../../config/ProjectConfiguration.class.php';

		$configuration = ProjectConfiguration::getApplicationConfiguration('amji', 'dev', true);
		$this->context = sfContext::createInstance($configuration);
		$this->user = $this->context->getUser();

	}

	protected $user = null;

	public function isAuthenticated()
	{
		return $this->getUser()->isAuthenticated();
	}

	public function logout()
	{
		return $this->getUser()->signOut();
	}

	protected function getContext()
	{
		return $this->context;
	}

	protected function getUser()
	{
		return $this->user;
	}


}

?>