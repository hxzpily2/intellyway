package view
{
	import commun.Actions;
	
	import flash.events.Event;
	
	import mx.controls.Alert;
	
	import org.puremvc.as3.interfaces.IMediator;
	import org.puremvc.as3.interfaces.INotification;
	import org.puremvc.as3.patterns.mediator.Mediator;
	
	public class ApplicationMediateur extends Mediator implements IMediator
	{
		public static const NAME:String = 'ApplicationMediateur'; 
		
		public function ApplicationMediateur(viewComponent:Object=null)
		{
			super(NAME, viewComponent);
			app.inscWindow.addEventListener(Actions.CREATAUSER,createUser);
		}
		
		public function get app():amjiIM{  
            return viewComponent as amjiIM;  
        }
        
        public function createUser(event : Event):void{
        	Alert.show("ok");
        }
		
		override public function listNotificationInterests():Array  
        {  
            return [  
              	Actions.CREATAUSER,ApplicationFacade.LOGINSUCCESS,ApplicationFacade.INSCRSUCCESS
        	]
        }
        
        override public function handleNotification(notification:INotification):void  
        {  
              
            switch ( notification.getName() )  
            {  
            	case ApplicationFacade.INSCRSUCCESS:
            		app.inscWindow.showAlert();
            		break;
            }
        }    

	}
}