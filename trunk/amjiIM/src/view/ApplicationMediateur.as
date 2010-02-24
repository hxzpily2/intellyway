package view
{
	import com.jivesoftware.spark.chats.SparkChat;
	
	import commun.AcceptContact;
	import commun.Actions;
	import commun.Constantes;
	import commun.InviteChatEvent;
	import commun.components.AmjiAlert;
	
	import flash.display.NativeWindowType;
	import flash.events.Event;
	import flash.utils.Dictionary;
	
	import model.ApplicationProxy;
	import model.vo.CreateUserVO;
	import model.vo.InviteContactVO;
	
	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	import mx.managers.PopUpManager;
	
	import org.igniterealtime.xiff.conference.Room;
	import org.igniterealtime.xiff.core.EscapedJID;
	import org.igniterealtime.xiff.core.UnescapedJID;
	import org.igniterealtime.xiff.data.Presence;
	import org.igniterealtime.xiff.events.ConnectionSuccessEvent;
	import org.igniterealtime.xiff.events.DisconnectionEvent;
	import org.igniterealtime.xiff.events.LoginEvent;
	import org.igniterealtime.xiff.events.RoomEvent;
	import org.igniterealtime.xiff.events.XIFFErrorEvent;
	import org.puremvc.as3.interfaces.IMediator;
	import org.puremvc.as3.interfaces.INotification;
	import org.puremvc.as3.patterns.mediator.Mediator;
	
	import view.contacts.SearchContact;
	
	
	
	public class ApplicationMediateur extends Mediator implements IMediator
	{
		public static const NAME:String = 'ApplicationMediateur'; 
		private var chats:Object = {};
		private var queuedRooms:Array = [];
		public var statutdic :  Dictionary = new Dictionary();
		
		public function ApplicationMediateur(viewComponent:Object=null)
		{
			super(NAME, viewComponent);
			app.mainWindow = new MainWindow();
			app.mainWindow.visible=false;	
			app.mainWindow.type = NativeWindowType.LIGHTWEIGHT;
			app.mainWindow.systemChrome = "none";
			app.mainWindow.transparent = true;	
			app.mainWindow.open();
			app.mainWindow.addEventListener(Actions.SHOWSEARCHCONTACT, showSearchContact);
			app.mainWindow.addEventListener(Actions.CLOSEINSCWIN,closeWindow);
			app.mainWindow.contactView.addEventListener(Actions.STATUTCHANGE,changeStatut);
			app.mainWindow.contactView.addEventListener(Actions.PSEUDOCHANGE,pseudoChange);
			app.mainWindow.contactView.addEventListener(Actions.ACCEPTINVITATION,acceptInvitation);
			app.mainWindow.contactView.addEventListener(Actions.IGNOREINVITATION,ignoreInvitation);
			app.mainWindow.contactView.addEventListener(Actions.INVITECHAT,inviteChat);
			
			statutdic[Constantes.ENLIGNE] = null;
			statutdic[Constantes.HORSLIGNE] = Presence.TYPE_UNAVAILABLE;
			statutdic[Constantes.ABSENT] = Presence.SHOW_AWAY;
			statutdic[Constantes.DERETOUR] = Presence.SHOW_XA;
			statutdic[Constantes.OCCUPE] = Presence.SHOW_DND;
		}
		
		public function inviteChat(event : InviteChatEvent):void{
			var jid : UnescapedJID = new UnescapedJID(event.username);
			var chat:SparkChat = getChat(jid) as SparkChat;
			if(!chat)
				chat = new SparkChat(jid);
				
			chats[jid.bareJID] = chat;			
		}
		
		public function getChat(jid:UnescapedJID):SparkChat 
		{
			return chats[jid.bareJID];
		}
		
		public function get app():amjiIM{  
            return viewComponent as amjiIM;  
        }           
        
        public function acceptInvitation(event : AcceptContact):void{
        	facade.sendNotification(Actions.GENERICUSER,event.id,Actions.ACCEPTINVITATION);
        }
        
        public function ignoreInvitation(event : AcceptContact):void{
        	facade.sendNotification(Actions.GENERICUSER,event.id,Actions.IGNOREINVITATION);
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
        	PopUpManager.addPopUp(app.loader,app.searchContactWin,true);
			PopUpManager.centerPopUp(app.loader);   
        	facade.sendNotification(Actions.GENERICUSER,inviteVO,Actions.ADDCONTACT);
        	var body : Object = new Object;			
        }
        
        public function searchContact(event : Event):void{     
        	PopUpManager.addPopUp(app.loader,app.searchContactWin,true);
			PopUpManager.centerPopUp(app.loader);   	
        	sendNotification(Actions.GENERICUSER,app.searchContactWin.txtCritere.text,Actions.SEARCHCONTACT);
        }
        
        public function closeWindow(event : Event):void{        	
        	app.closeHandler();
        }
		
		public function changeStatut(event : Event):void{
			sendNotification(Actions.GENERICUSER,app.mainWindow.contactView.comboBox.selectedItem.key,Actions.STATUTCHANGE);
			var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
			proxy.userConnected.userVO.connstatut = app.mainWindow.contactView.comboBox.selectedItem.key;
			this.sendStatutChangeMessage(app.mainWindow.contactView.comboBox.selectedItem.key);
		}	
		
		public function pseudoChange(event : Event):void{
			sendNotification(Actions.GENERICUSER,app.mainWindow.contactView.txtPseudo.text,Actions.PSEUDOCHANGE);
			var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
			proxy.userConnected.userVO.pseudo = app.mainWindow.contactView.txtPseudo.text;
			this.sendPseudoChangeMessage(app.mainWindow.contactView.txtPseudo.text);
		}
		
		public function sendStatutChangeMessage(statut : String):void{
			if(statut!=Constantes.HORSLIGNE)			
				ApplicationFacade.getPresenceManager().changePresence(statutdic[statut],statutdic[statut]);
			else{
				var recipient:EscapedJID = new EscapedJID(ApplicationFacade.getConnexion().server);
				var unavailablePresence:Presence = new Presence(recipient, null, Presence.TYPE_UNAVAILABLE, null, "Logged out");
				ApplicationFacade.getConnexion().send(unavailablePresence);
			}
		}
		
		public function sendPseudoChangeMessage(pseudo : String):void{
			
		}	
		
		private function handleBoshConnection( event:Event ):void
	    {
			Alert.show("ok");			
	    }
		
		private function handleConnection( event:ConnectionSuccessEvent ):void
	    {
							
	    }
	
	    private function handleLogin( event:LoginEvent ):void
	    {
	      Alert.show( "Authentication successful!", "Authentication" );
	      this.joinRoom();
	      //this.createUser("AmjiIMUser1","amjitesttesttest");	      
	    }
	    
	    public function joinRoom():void{
	    	var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
	    	ApplicationFacade.getInstance().room = new Room(ApplicationFacade.getConnexion());
		  	ApplicationFacade.getInstance().room.roomJID = new UnescapedJID("amji@conference.jaim.at");
		  	ApplicationFacade.getInstance().room.nickname = "amjiUser_"+proxy.userConnected.userVO.idamji_user.toString();
		  	ApplicationFacade.getInstance().room.addEventListener(RoomEvent.ROOM_JOIN, onRoomJoin);	
		  	ApplicationFacade.getInstance().room.addEventListener(RoomEvent.USER_JOIN, handleUserJoin);	  
		  	ApplicationFacade.getInstance().room.join();	  	
	    }
	    
	    
	    
	    public function onRoomJoin(event : RoomEvent):void{
	    	//Alert.show("ok");
	    }
	    
	    public function handleUserJoin(event : RoomEvent){
	    	Alert.show(event.nickname);
	    }
	    
	    private function handleError( event:XIFFErrorEvent ):void
	    {
	      Alert.show( event.errorCondition, "Error" );
	    }
	
	    private function handleDisconnect( event:DisconnectionEvent ):void
	    {
	      
	    }

	
		
		public function createConsumerForType():void{
			
		}
		
		public function createConsumerForContacts():void{
			
		}
		
		override public function listNotificationInterests():Array  
        {  
            return [  
              	Actions.CREATAUSER,ApplicationFacade.LOGINFAILED,ApplicationFacade.LOGINSUCCESS,ApplicationFacade.INSCRSUCCESS,
              	ApplicationFacade.SEARCHSUCCESS,ApplicationFacade.INVITESUCCESS,ApplicationFacade.INVITEFAILED
        	]
        }
        
        override public function handleNotification(notification:INotification):void  
        {  
              
            switch ( notification.getName() )  
            {  
            	case ApplicationFacade.INSCRSUCCESS:
            		app.poopupFugace.show(app.geti18nText('text.inscription.congratulation'),350,120);
            		app.poopupFugace.addEventListener("CLOSED",showLoginWindow);            		
            		app.hideLoader();            		
            		app.inscWindow.close();
            		ApplicationFacade.getConnexion().disconnect();            		
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
            		for(var i : Number = 0;i<(app.mainWindow.contactView.comboBox.dataProvider as ArrayCollection).length;i++){
            			if((app.mainWindow.contactView.comboBox.dataProvider as ArrayCollection).getItemAt(i).key == app.mainWindow.contactView.user.userVO.connstatut){
            				app.mainWindow.contactView.comboBox.selectedIndex = i;
            				break;
            			} 
            		}            		
            		//this.createConsumerForType();
            		//this.createConsumerForContacts();
            		app.mainWindow.contactView.lblInvitations.value = proxy.userConnected.listInvitations.length;
            		app.mainWindow.contactView.listeInvitation.source = proxy.userConnected.listInvitations;
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
            		PopUpManager.removePopUp(app.loader);
            		break; 
            	case ApplicationFacade.INVITESUCCESS:
            		var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
            		app.mainWindow.contactView.listeContact = new ArrayCollection;
            		app.mainWindow.contactView.listeContact.source = proxy.userConnected.listeContacts;
            		PopUpManager.removePopUp(app.loader);
            		app.searchContactWin.close();
            		break; 
            	case ApplicationFacade.INVITEFAILED:            		
            		PopUpManager.removePopUp(app.loader);
            		app.searchContactWin.close();
            		app.alertWindow = new AmjiAlert();
            		app.alertWindow.show("Ce contact figure déjà sur<br>votre liste",350,150,Constantes.ERROR);            		
            		break;       		
            }
        }    

	}
}