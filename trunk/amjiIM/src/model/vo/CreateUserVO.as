package model.vo
{
	[RemoteClass(alias="amji.vo.CreateUserVO")]     
    [Bindable]  
	public class CreateUserVO
	{
		
		public var idamji_user : int;
 		public var pseudo : String
 		public var email : String
 		public var nom : String
 		public var prenom : String
 		public var adr : String
 		public var tel : String
 		public var etudiant : Boolean
 		public var ecole :  String
 		public var niveau  :  String
 		public var salarie : Boolean
 		public var statut  :  String
 		public var societe  :  String
 		public var password  :  String
 		public var confirmpassword  :  String
 		public var civilite  :  String
 
		public function CreateUserVO()
		{
		}

	}
}