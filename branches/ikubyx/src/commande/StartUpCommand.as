package commande
{
	import model.ApplicationProxy;
	
	import org.puremvc.as3.interfaces.ICommand;
	import org.puremvc.as3.interfaces.INotification;
	import org.puremvc.as3.patterns.command.SimpleCommand;
	
	import view.ApplicationMediateur;
	
	public class StartUpCommand  extends SimpleCommand implements ICommand  
	{
		override public function execute(notification:INotification):void  
        {  
           	facade.registerProxy(new ApplicationProxy(ApplicationProxy.NAME));
             
            var app:ikubyx = notification.getBody() as ikubyx;  
  			
            facade.registerMediator( new ApplicationMediateur( app ) );
            //facade.registerMediator( new ApplicationMediateur( app ) );
            //facade.sendNotification(Actions.CREATAUSER);  
                            
        } 

	}
}