package commande
{
	import commun.Actions;
	
	import org.puremvc.as3.interfaces.ICommand;
	import org.puremvc.as3.interfaces.INotification;
	import org.puremvc.as3.patterns.command.SimpleCommand;
	
	public class StartUpCommand  extends SimpleCommand implements ICommand  
	{
		override public function execute(notification:INotification):void  
        {  
           	//facade.registerProxy(new ApplicationProxy(ApplicationProxy.NAME));
             
            var app:amjiIM = notification.getBody() as amjiIM;  
  			
            //facade.registerMediator( new AuthentificationMediateur( app.loginForm ) );
            //facade.registerMediator( new ApplicationMediateur( app ) );
            //facade.sendNotification(Actions.CREATAUSER);  
                            
        } 

	}
}