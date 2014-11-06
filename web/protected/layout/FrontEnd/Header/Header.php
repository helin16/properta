<?php
/**
 * Header template
 *
 * @package    Web
 * @subpackage Layout
 * @author     lhe
 */
class Header extends TTemplateControl
{
	public function onLoad($param)
	{
		parent::onLoad($param);
		$userLoggedIn = (Core::getUser() instanceof UserAccount && Core::getUser()->getId() !== UserAccount::ID_GUEST_ACCOUNT);
		$this->user_menu_not_login->Visible = !$userLoggedIn;
		$this->user_menu_login->Visible = $userLoggedIn;
	}
}
?>