package business
{
	import commun.Actions;
	
	import model.vo.CreateUserVO;
	import model.vo.InviteContactVO;
	import model.vo.UserVO;
	
	import mx.rpc.AsyncToken;
	import mx.rpc.IResponder;
	import mx.rpc.remoting.mxml.RemoteObject;
	
	public class UserDelegate
	{
		private var responder : IResponder;  
    	private var service : Object; 
    	
		public function UserDelegate(pResponder : IResponder)
		{
			service = new RemoteObject();  
            service.destination="UserService";  
            service.makeObjectsBindable=true;  
            responder = pResponder;
		}
		
		public function createUser(user : CreateUserVO):void{
			var asynchToken:AsyncToken = service.createUser(user);  
            asynchToken.addResponder(responder);
            asynchToken.action = Actions.CREATAUSER;            
		}
		
		public function login(user : UserVO):void{
			var asynchToken:AsyncToken = service.login(user);  
            asynchToken.addResponder(responder);
            asynchToken.action = Actions.LOGIN;            
		}
		
		public function searchContact(critere : String):void{
			var asynchToken:AsyncToken = service.searchContacts(critere);  
            asynchToken.addResponder(responder);
            asynchToken.action = Actions.SEARCHCONTACT;
		}
		
		public function addContact(invite : InviteContactVO):void{
			var asynchToken:AsyncToken = service.inviteContact(invite);  
            asynchToken.addResponder(responder);
            asynchToken.action = Actions.ADDCONTACT;
		}
		
		public function statutChange(statut : String):void{
			var asynchToken:AsyncToken = service.statutChange(statut);  
            asynchToken.addResponder(responder);
            asynchToken.action = Actions.STATUTCHANGE;
		}
		
		public function changePseudo(pseudo : String):void{
			var asynchToken:AsyncToken = service.changePseudo(pseudo);  
            asynchToken.addResponder(responder);
            asynchToken.action = Actions.PSEUDOCHANGE;
		}
		
		public function accepteInvitation(id:Number):void{
			var asynchToken:AsyncToken = service.accepteInvitation(id);  
            asynchToken.addResponder(responder);
            asynchToken.action = Actions.ACCEPTINVITATION;
		}
		
		public function ignoreInvitation(id:Number):void{
			var asynchToken:AsyncToken = service.ignoreInvitation(id);  
            asynchToken.addResponder(responder);
            asynchToken.action = Actions.IGNOREINVITATION;
		}

	}
}