package model.vo
{
	
	[RemoteClass(alias="amji.vo.LoginVO")]     
    [Bindable]
	public class LoginVO
	{
		public var userVO : UserVO;
		public var listeContacts : Array = new Array;
		public var listInvitations : Array = new Array;
		
		public function LoginVO()
		{
		}

	}
}