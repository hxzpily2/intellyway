package commun
{
	
	import flash.utils.ByteArray;
	
	public class Commun
	{
		public function Commun()
		{
		}
		
		public static var checkLogin : String = "checkLogin";
		public static var checkPass : String = "checkPass";
		public static var login : String = "login";
		public static var pass : String = "pass";		
		
        
        public static function getDomainFromMail(email : String):String{
        	var a : Number = email.substr(0,email.indexOf("@")).length;
        	var b : Number = email.substr(0,email.lastIndexOf(".")).length;
        	return email.substr(email.indexOf("@")+1,b-a-1);        	
        }
        
        public static function getJidFromMail(email : String):String{
        	var a : Number = email.substr(0,email.indexOf("@")).length;
        	var b : Number = email.substr(0,email.lastIndexOf(".")).length;
        	return Constantes.XMPPUSERPREFIX+email.substr(0,email.lastIndexOf("@"))+email.substr(email.indexOf("@")+1,b-a-1);        	
        }

	}
}