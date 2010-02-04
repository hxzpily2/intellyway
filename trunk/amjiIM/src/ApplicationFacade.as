package
{
	import commande.StartUpCommand;
	import commande.UserCommande;
	
	import commun.Actions;
	
	import org.puremvc.as3.interfaces.IFacade;
	import org.puremvc.as3.patterns.facade.Facade;
	
	public class ApplicationFacade extends Facade implements IFacade  
	{
		public static const APP_STARTUP:String = "AppStartUp";
		public static const LOGINSUCCESS:String = "LOGINSUCCESS";
		public static const INSCRSUCCESS:String = "INSCRSUCCESS";
		public static const INSCRFAILED:String = "INSCRFAILED"; 
		 
		
		public static function getInstance() : ApplicationFacade {  
  
            if ( instance == null ) instance = new ApplicationFacade( );  
  
            return instance as ApplicationFacade;  
  
        }
        
        override protected function initializeController():void  
        {  
            super.initializeController();  
  
            registerCommand(APP_STARTUP, StartUpCommand); 
            registerCommand(Actions.CREATAUSER, UserCommande);  
            //registerCommand(APPLICATIONNOTIFICATION, ApplicationCommand);           
              
              
        }  
        
        
  
        public function startup( app:amjiIM ):void  
        {             
            sendNotification( ApplicationFacade.APP_STARTUP, app ) ;  
        }  

	}
}