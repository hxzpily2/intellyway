package
{
	import com.jivesoftware.spark.managers.ConnectionManager;
	import com.jivesoftware.spark.managers.PresenceManager;
	import com.jivesoftware.spark.managers.SparkManager;
	
	import commande.StartUpCommand;
	import commande.UserCommande;
	
	import commun.Actions;
	import commun.Constantes;
	
	import org.igniterealtime.xiff.conference.InviteListener;
	import org.igniterealtime.xiff.conference.Room;
	import org.igniterealtime.xiff.core.XMPPConnection;
	import org.igniterealtime.xiff.im.Roster;
	import org.puremvc.as3.interfaces.IFacade;
	import org.puremvc.as3.patterns.facade.Facade;
	
	public class ApplicationFacade extends Facade implements IFacade  
	{
		public static const APP_STARTUP:String = "AppStartUp";		
		public static const INSCRSUCCESS:String = "INSCRSUCCESS";
		public static const INSCRFAILED:String = "INSCRFAILED"; 
		public static const LOGINSUCCESS:String = "LOGINSUCCESS";
		public static const LOGINFAILED:String = "LOGINFAILED";
		public static const SEARCHSUCCESS:String = "SEARCHSUCCESS";
		public static const INVITESUCCESS:String = "INVITESUCCESS"; 
		public static const INVITEFAILED:String = "INVITEFAILED";
		public static const ACCEPTCONTACT:String = "ACCEPTCONTACT";
		public static const IGNORECONTACT:String = "IGNORECONTACT";  
		
		public static function getInstance() : ApplicationFacade {  
  
            if ( instance == null ) instance = new ApplicationFacade( );  
  
            return instance as ApplicationFacade;  
  
        }
        
        override protected function initializeController():void  
        {  
            super.initializeController();  
  
            registerCommand(APP_STARTUP, StartUpCommand); 
            registerCommand(Actions.GENERICUSER, UserCommande);  
            //registerCommand(APPLICATIONNOTIFICATION, ApplicationCommand);           
              
              
        }  
        
        public static var connection : XMPPConnection;
        public static var connectionManager : ConnectionManager;
        public static var presenceManager : PresenceManager;
        public static var sparkManager : SparkManager; 
        public var mainRoster : Roster;
        public var inviteListener : InviteListener;
        public var room : Room;
        
  
        public function startup( app:amjiIM ):void  
        {             
            sendNotification( ApplicationFacade.APP_STARTUP, app ) ;  
        } 
        
        public static function getConnexion() : XMPPConnection {  
  
            if ( connection == null ){ 
            	connection = new XMPPConnection();
	      		connection.port = Constantes.XMPPPORT;
	      		connection.resource = "amjiim";      		
	      		connection.server = Constantes.XMPPSERVEUR;	
	      		connectionManager = new ConnectionManager(connection);
	      		SparkManager.connectionManager = connectionManager;      		           	
            }  
  
            return connection as XMPPConnection;  
  
        } 
        
        public static function getConnectionManager() : ConnectionManager { 
        	if ( connectionManager == null ){ 
        		connectionManager = new ConnectionManager();
        	}
        	return connectionManager as ConnectionManager;
        }
        
        public static function getPresenceManager() : PresenceManager { 
        	if ( presenceManager == null ){ 
        		presenceManager = new PresenceManager();
        	}
        	return presenceManager as PresenceManager;
        }
        
        public static function getSparkManager() : SparkManager { 
        	if ( sparkManager == null ){ 
        		sparkManager = new SparkManager();
        	}
        	return sparkManager as SparkManager;
        }        
        

	}
}