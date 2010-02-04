package commande
{
	import business.UserDelegate;
	
	import commun.Actions;
	
	import model.vo.CreateUserVO;
	
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
		
		override public function result(data : Object):void{
			switch((data.token as AsyncToken).action){
				case Actions.CREATAUSER:
					Alert.show(data.result.toString());
					break;
			}
		}
		
		override public function fault(info : Object):void{
			var errorMessage:ErrorMessage = info.message as ErrorMessage;
			Alert.show(info.toString());
		}

	}
}