package model.vo
{
	[RemoteClass(alias="amji.vo.UserVO")]     
    [Bindable]
	public class UserVO
	{
		public var login : String;
		public var pass : String;
		public var statut : String;
		public function UserVO()
		{
		}

	}
}