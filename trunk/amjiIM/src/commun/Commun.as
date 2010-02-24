package commun
{
	import flash.data.EncryptedLocalStore;
	import flash.display.NativeMenu;
	import flash.display.NativeMenuItem;
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
		
		
		public static function addChildrenToMenu(menu:NativeMenu,
                                children:XMLList):NativeMenuItem
        {
            var menuItem:NativeMenuItem;
            var submenu:NativeMenu;
            
            for each (var child:XML in children)
            {
                if (String(child.@label).length > 0)
                {
                    menuItem = new NativeMenuItem(child.@label);
                    menuItem.name = child.name();
                }
                else
                {
                    menuItem = new NativeMenuItem(child.name());
                    menuItem.name = child.name();
                }
                menu.addItem(menuItem);
                if (child.children().length() > 0)
                {
                    menuItem.submenu = new NativeMenu();
                    addChildrenToMenu(menuItem.submenu,child.children());
                }
            }
            return menuItem;
        }
        
        public static function getDomainFromMail(email : String):String{
        	var a : Number = email.substr(0,email.indexOf("@")).length;
        	var b : Number = email.substr(0,email.lastIndexOf(".")).length;
        	return email.substr(email.indexOf("@")+1,b-a-1);        	
        }

	}
}