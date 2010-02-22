package commande
{
	import business.UserDelegate;
	
	import commun.Actions;
	import commun.Errors;
	
	import model.ApplicationProxy;
	import model.vo.CreateUserVO;
	import model.vo.InviteContactVO;
	import model.vo.LoginVO;
	import model.vo.UserVO;
	
	import mx.controls.Alert;
	import mx.messaging.messages.ErrorMessage;
	import mx.rpc.AsyncToken;
	import mx.rpc.IResponder;
	
	import org.puremvc.as3.interfaces.ICommand;
	import org.puremvc.as3.interfaces.INotification;
	import org.puremvc.as3.patterns.command.SimpleCommand;
	
	public class UserCommande extends SimpleCommand implements ICommand,IResponder
	{
		public function createUser(notification : INotification):void{
			var service : UserDelegate = new UserDelegate(this);
			var user : CreateUserVO = notification.getBody() as CreateUserVO;
			
			service.createUser(user);			
		}
		
		public function login(notification : INotification):void{
			var service : UserDelegate = new UserDelegate(this);
			var user : UserVO= notification.getBody() as UserVO;
			
			service.login(user);
		}
		
		public function searchContact(notification : INotification){
			var service : UserDelegate = new UserDelegate(this);
			var critere : String = notification.getBody() as String;
			
			service.searchContact(critere);
		}
		
		public function addContact(notification : INotification):void{
			var service : UserDelegate = new UserDelegate(this);
			var invitevo : InviteContactVO = notification.getBody() as InviteContactVO;
			service.addContact(invitevo);
		}
		
		public function statutChange(notification : INotification):void{
			var service : UserDelegate = new UserDelegate(this);
			service.statutChange(notification.getBody() as String);
		}
		
		public function changePseudo(notification : INotification):void{
			var service : UserDelegate = new UserDelegate(this);
			service.changePseudo(notification.getBody() as String);
		}
		
		public function accepteInvitation(notification : INotification):void{
			var service : UserDelegate = new UserDelegate(this);
			service.accepteInvitation(notification.getBody() as Number);
		}
		
		public function ignoreInvitation(notification : INotification):void{
			var service : UserDelegate = new UserDelegate(this);
			service.ignoreInvitation(notification.getBody() as Number);
		}
		
		override public function result(data : Object):void{
			switch((data.token as AsyncToken).action){
				case Actions.CREATAUSER:
					var test : Number = data.result as Number;					
					if(data.result!=null){						
						sendNotification(ApplicationFacade.INSCRSUCCESS,data.result);
					}else{						
						sendNotification(ApplicationFacade.INSCRFAILED);
					}
					break;
				case Actions.LOGIN:
					if(data.result == null){						
						sendNotification(ApplicationFacade.LOGINFAILED);
					}else{
						var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
						proxy.userConnected = data.result as LoginVO;						
						sendNotification(ApplicationFacade.LOGINSUCCESS);
					}
					break;
				case Actions.SEARCHCONTACT:
					var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
					proxy.listeSearchContact = data.result as Array;
					sendNotification(ApplicationFacade.SEARCHSUCCESS);
					break;
				case Actions.ADDCONTACT:
					var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
					var user : CreateUserVO = data.result as CreateUserVO
					proxy.userConnected.listeContacts.push(user);					
					sendNotification(ApplicationFacade.INVITESUCCESS);
					break;
			}
		}
		
		override public function fault(info : Object):void{
			var errorMessage:ErrorMessage = info.message as ErrorMessage;
			if(errorMessage.faultString == Errors.INVITATIONEXIST){
				sendNotification(ApplicationFacade.INVITEFAILED,errorMessage.faultString);
			}else{
				Alert.show(info.fault.toString());
			}
			
		}

	}
}