package commande
{
	import business.UserDelegate;
	
	import commun.Actions;
	
	import model.ApplicationProxy;
	import model.vo.CreateUserVO;
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
		
		override public function result(data : Object):void{
			switch((data.token as AsyncToken).action){
				case Actions.CREATAUSER:
					var test : Boolean = data.result as Boolean;
					
					if(test==true){						
						sendNotification(ApplicationFacade.INSCRSUCCESS);
					}else{						
						sendNotification(ApplicationFacade.INSCRFAILED);
					}
					break;
				case Actions.LOGIN:
					if(data.result == null){						
						sendNotification(ApplicationFacade.LOGINFAILED);
					}else{
						var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
						proxy.userConnected = data.result as CreateUserVO;
						sendNotification(ApplicationFacade.LOGINSUCCESS);
					}
					break;
			}
		}
		
		override public function fault(info : Object):void{
			var errorMessage:ErrorMessage = info.message as ErrorMessage;
			Alert.show(info.toString());
		}

	}
}