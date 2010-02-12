package view
{
	import commun.Actions;
	import commun.Constantes;
	import commun.components.AmjiAlert;
	
	import flash.display.NativeWindowType;
	import flash.events.Event;
	
	import model.ApplicationProxy;
	import model.vo.CreateUserVO;
	import model.vo.InviteContactVO;
	
	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	
	import org.puremvc.as3.interfaces.IMediator;
	import org.puremvc.as3.interfaces.INotification;
	import org.puremvc.as3.patterns.mediator.Mediator;
	
	import view.contacts.SearchContact;
	
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
			app.mainWindow.addEventListener(Actions.SHOWSEARCHCONTACT, showSearchContact);
			app.mainWindow.addEventListener(Actions.CLOSEINSCWIN,closeWindow);
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
        
        public function showSearchContact(event : Event):void{
        	app.searchContactWin = new SearchContact;        		
			app.searchContactWin.type = NativeWindowType.LIGHTWEIGHT;
			app.searchContactWin.systemChrome = "none";
			app.searchContactWin.transparent = true;	
        	app.searchContactWin.open();
        	app.searchContactWin.addEventListener(Actions.SEARCHCONTACT,searchContact);
        	app.searchContactWin.addEventListener(Actions.ADDCONTACT,addContact);
        	app.mainWindow.nativeWindow.orderInBackOf(app.searchContactWin.nativeWindow);
        	app.searchContactWin.nativeWindow.orderToFront();
        }
        
        public function addContact(event : Event):void{
        	var inviteVO : InviteContactVO = new InviteContactVO;
        	var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
        	inviteVO.idcontact = (proxy.listeSearchContact[app.searchContactWin.listContact.selectedIndex] as CreateUserVO).idamji_user;
        	inviteVO.message = app.searchContactWin.txtMsgInvit.htmlText;
        	facade.sendNotification(Actions.GENERICUSER,inviteVO,Actions.ADDCONTACT);
        }
        
        public function searchContact(event : Event):void{        	
        	sendNotification(Actions.GENERICUSER,app.searchContactWin.txtCritere.text,Actions.SEARCHCONTACT);
        }
        
        public function closeWindow(event : Event):void{        	
        	app.closeHandler();
        }
		
		override public function listNotificationInterests():Array  
        {  
            return [  
              	Actions.CREATAUSER,ApplicationFacade.LOGINFAILED,ApplicationFacade.LOGINSUCCESS,ApplicationFacade.INSCRSUCCESS,
              	ApplicationFacade.SEARCHSUCCESS,ApplicationFacade.INVITESUCCESS
        	]
        }
        
        override public function handleNotification(notification:INotification):void  
        {  
              
            switch ( notification.getName() )  
            {  
            	case ApplicationFacade.INSCRSUCCESS:
            		app.poopupFugace.show(app.geti18nText('text.inscription.congratulation'),310,120);
            		app.poopupFugace.addEventListener("CLOSED",showLoginWindow);            		
            		app.hideLoader();
            		app.inscWindow.close();            		
            		break;
            	case ApplicationFacade.INSCRFAILED:
            		app.hideLoader();
            		break; 
            	case ApplicationFacade.LOGINSUCCESS:            		           		          		
            		var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
            		app.hideLoader();
            		app.mainWindow.nativeWindow.visible = true;
            		app.mainWindow.contactView.listeContact = new ArrayCollection;
            		app.mainWindow.contactView.listeContact.source = proxy.userConnected.listeContacts;
            		app.mainWindow.contactView.user = proxy.userConnected;
            		app.window.nativeWindow.visible = false;
            		break;
            	case ApplicationFacade.LOGINFAILED:
            		app.hideLoader();
            		app.alertWindow = new AmjiAlert();
            		app.alertWindow.show(app.geti18nText("text.login.error"),350,150,Constantes.ERROR);            		
            		break;  
            	case ApplicationFacade.SEARCHSUCCESS:
            		var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
            		app.searchContactWin.listeContactSearch = new ArrayCollection;
            		app.searchContactWin.listeContactSearch.source = proxy.listeSearchContact;
            		break; 
            	case ApplicationFacade.INVITESUCCESS:
            		var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
            		app.mainWindow.contactView.listeContact = new ArrayCollection;
            		app.mainWindow.contactView.listeContact.source = proxy.userConnected.listeContacts;
            		break;        		
            }
        }    

	}
}