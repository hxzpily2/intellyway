package model.vo
{
	import mx.collections.ArrayCollection;
	[RemoteClass(alias="amji.vo.LoginVO")]     
    [Bindable]
	public class LoginVO
	{
		public var userVO : UserVO;
		public var listeContacts : ArrayCollection;
		
		public function LoginVO()
		{
		}

	}
}