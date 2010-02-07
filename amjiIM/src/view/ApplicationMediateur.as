package view
{
	import commun.Actions;
	
	import flash.display.NativeWindowType;
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
			app.mainWindow = new MainWindow();
			app.mainWindow.visible=false;	
			app.mainWindow.type = NativeWindowType.LIGHTWEIGHT;
			app.mainWindow.systemChrome = "none";
			app.mainWindow.transparent = true;	
			app.mainWindow.open();
		}
		
		public function get app():amjiIM{  
            return viewComponent as amjiIM;  
        }
        
        public function createUser(event : Event):void{
        	Alert.show("ok");
        }
        
        public function showLoginWindow(event : Event):void{
        	app.window.nativeWindow.visible = true;
        }
		
		override public function listNotificationInterests():Array  
        {  
            return [  
              	Actions.CREATAUSER,ApplicationFacade.LOGINFAILED,ApplicationFacade.LOGINSUCCESS,ApplicationFacade.INSCRSUCCESS
        	]
        }
        
        override public function handleNotification(notification:INotification):void  
        {  
              
            switch ( notification.getName() )  
            {  
            	case ApplicationFacade.INSCRSUCCESS:
            		app.poopupFugace.show(app.poopupFugace.textSuccess,250,100);
            		app.poopupFugace.addEventListener("CLOSED",showLoginWindow);            		
            		app.hideLoader();
            		app.inscWindow.close();            		
            		break;
            	case ApplicationFacade.INSCRFAILED:
            		app.hideLoader();
            		break; 
            	case ApplicationFacade.LOGINSUCCESS:            		
            		app.hideLoader();
            		break;
            	case ApplicationFacade.LOGINFAILED:
            		app.hideLoader();
            		break;           		
            }
        }    

	}
}