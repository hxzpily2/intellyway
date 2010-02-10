package commun
{
	import flash.data.EncryptedLocalStore;
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
		
		public static function storeEncrypt(key : String,value : String):void{
				var bytes : ByteArray = new ByteArray(); 
				bytes.writeUTFBytes(value); 
				EncryptedLocalStore.setItem(key, bytes);				
		}
		
		public static function getStoredItem(key : String):String{
			var bytes : ByteArray = EncryptedLocalStore.getItem(key);
			if(bytes!=null)
				return bytes.readUTFBytes(bytes.length);
			else return null;
		}
		
		public static function clearStoredItem(key : String):void{
			EncryptedLocalStore.removeItem(key);
		}
		
		public static function clearAllStoredItem():void{
			EncryptedLocalStore.reset();
		}
	}
}