package view
{
	import com.jivesoftware.spark.chats.SparkChat;
	
	import commun.AcceptContact;
	import commun.Actions;
	import commun.Commun;
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
	
	import org.igniterealtime.xiff.conference.InviteListener;
	import org.igniterealtime.xiff.conference.Room;
	import org.igniterealtime.xiff.core.EscapedJID;
	import org.igniterealtime.xiff.core.UnescapedJID;
	import org.igniterealtime.xiff.data.Message;
	import org.igniterealtime.xiff.data.Presence;
	import org.igniterealtime.xiff.data.events.MessageEventExtension;
	import org.igniterealtime.xiff.events.ConnectionSuccessEvent;
	import org.igniterealtime.xiff.events.DisconnectionEvent;
	import org.igniterealtime.xiff.events.InviteEvent;
	import org.igniterealtime.xiff.events.LoginEvent;
	import org.igniterealtime.xiff.events.MessageEvent;
	import org.igniterealtime.xiff.events.RoomEvent;
	import org.igniterealtime.xiff.events.RosterEvent;
	import org.igniterealtime.xiff.events.XIFFErrorEvent;
	import org.igniterealtime.xiff.im.Roster;
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
			
			ApplicationFacade.getInstance().mainRoster = new Roster(ApplicationFacade.getConnexion());
    		ApplicationFacade.getInstance().mainRoster.addEventListener(RosterEvent.ROSTER_LOADED, onRoster);
    		ApplicationFacade.getInstance().mainRoster.addEventListener(RosterEvent.SUBSCRIPTION_DENIAL, onRoster);
    		ApplicationFacade.getInstance().mainRoster.addEventListener(RosterEvent.SUBSCRIPTION_REQUEST, onRoster);
    		ApplicationFacade.getInstance().mainRoster.addEventListener(RosterEvent.SUBSCRIPTION_REVOCATION, onRoster);
    		ApplicationFacade.getInstance().mainRoster.addEventListener(RosterEvent.USER_AVAILABLE, onRoster);
    		ApplicationFacade.getInstance().mainRoster.addEventListener(RosterEvent.USER_UNAVAILABLE, onRoster);
    		ApplicationFacade.getInstance().mainRoster.addEventListener(RosterEvent.USER_PRESENCE_UPDATED, onRoster);
    		
    		ApplicationFacade.getInstance().inviteListener = new InviteListener();
    		ApplicationFacade.getInstance().inviteListener.addEventListener(InviteEvent.INVITED,invited);    		
		}
		
		public function invited(event : InviteEvent):void{
			Alert.show("ok");
			
		}
		
		private function onRoster(event:RosterEvent):void {		
	        switch (event.type){
	            case RosterEvent.SUBSCRIPTION_REQUEST:
	                // Fill this bit in, obviously
	                break;
	            case RosterEvent.USER_UNAVAILABLE :
	                trace (event.jid + " is Unavailable (RosterEvent)");
	                break;
	            case RosterEvent.USER_AVAILABLE :
	                trace (event.jid + " is Available (RosterEvent)");
	                break;
	            case RosterEvent.SUBSCRIPTION_DENIAL :
	                trace (event.jid + " denied your request (RosterEvent)");
	                break;
	            case RosterEvent.SUBSCRIPTION_REVOCATION :
	                // this fires at unexpected times so ignore it.
	                // trace (event.jid + " revoked your presence (RosterEvent)");
	                break;
	            case RosterEvent.USER_PRESENCE_UPDATED:
	            	break;
	            default :
	                // do nothing... not recognized
	        }
	    }
		
		public function inviteChat(event : InviteChatEvent):void{
			var jid : UnescapedJID = new UnescapedJID(event.username+"@"+Constantes.XMPPSERVEUR);
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
	      //this.createUser("AmjiIMUser1","amjitesttesttest");	      
	    }
	    
	    public function createRoom():void{
	    	var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
	    	ApplicationFacade.getInstance().room = new Room(ApplicationFacade.getConnexion());
		  	ApplicationFacade.getInstance().room.roomJID = new UnescapedJID(Constantes.XMPPROOMPREFIX+Constantes.XMPPROOMCHAT+"@"+Constantes.XMPPCONFERENCESERVEUR);
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
	    
	    public function handleMessage(event : MessageEvent):void{
	    	var message : Message = event.data as Message
	    	switch (message.subject){
	    		case Actions.INVITECONTACT:
	    			app.alertWindow = new AmjiAlert();
            		app.alertWindow.show("vous avez reçu une nouvelle invitation",350,150,Constantes.ATTENTION); 
	    			break;
	    	}
	    }
	    
	    public function inviteContact(jid : UnescapedJID):void{
	    	var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
			var message:Message = new Message(jid.escaped);
			message.addExtension(new MessageEventExtension());
			message.from = new EscapedJID(Commun.getJidFromMail(proxy.userConnected.userVO.email)+"@"+Constantes.XMPPSERVEUR);
			message.body = "test";
			message.subject = Actions.INVITECONTACT;
			message.type = Message.TYPE_CHAT;		
			ApplicationFacade.getConnexion().send(message);	
	    }

		
		
		public function joinRoomForType():void{
			
		}
		
		public function joinRoomForChat():void{
			
		}
		
		override public function listNotificationInterests():Array  
        {  
            return [  
              	Actions.CREATAUSER,ApplicationFacade.LOGINFAILED,ApplicationFacade.LOGINSUCCESS,ApplicationFacade.INSCRSUCCESS,
              	ApplicationFacade.SEARCHSUCCESS,ApplicationFacade.INVITESUCCESS,ApplicationFacade.INVITEFAILED,
              	ApplicationFacade.IGNORECONTACT,ApplicationFacade.ACCEPTCONTACT
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
            		this.joinRoomForType();
            		this.joinRoomForChat();
            		app.mainWindow.contactView.lblInvitations.value = proxy.userConnected.listInvitations.length;
            		app.mainWindow.contactView.listeInvitation.source = proxy.userConnected.listInvitations;
            		ApplicationFacade.getConnexion().addEventListener(MessageEvent.MESSAGE,handleMessage);
            		this.sendStatutChangeMessage(app.window.comboBox.selectedItem.key);
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
            		this.inviteContact(new UnescapedJID(Commun.getJidFromMail((proxy.listeSearchContact[app.searchContactWin.listContact.selectedIndex] as CreateUserVO).email)+"@"+Constantes.XMPPSERVEUR));
            		break; 
            	case ApplicationFacade.INVITEFAILED:            		
            		PopUpManager.removePopUp(app.loader);
            		app.searchContactWin.close();
            		app.alertWindow = new AmjiAlert();
            		app.alertWindow.show("Ce contact figure déjà sur<br>votre liste",350,150,Constantes.ERROR);            		
            		break; 
            	case ApplicationFacade.IGNORECONTACT:
            		var user : CreateUserVO = notification.getBody() as CreateUserVO;
            		var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
            		var array : ArrayCollection = new ArrayCollection;
            		array.source = proxy.userConnected.listInvitations
            		for(var i : Number = 0;i<array.length;i++){
            			var temp : CreateUserVO = array.getItemAt(i) as CreateUserVO;
            			if(temp.idamji_user == user.idamji_user){
            				array.removeItemAt(i);
            				break;
            			}            				
            		}
            		proxy.userConnected.listInvitations = array.source;
            		app.mainWindow.contactView.listeInvitation.source = proxy.userConnected.listInvitations; 
            		app.mainWindow.contactView.lblInvitations.value = proxy.userConnected.listInvitations.length;
            		break;
            	case ApplicationFacade.ACCEPTCONTACT:            		
            		var user : CreateUserVO = notification.getBody() as CreateUserVO;
            		ApplicationFacade.getInstance().mainRoster.addContact(new UnescapedJID(Commun.getJidFromMail(user.email)),user.prenom+" "+user.nom);
            		var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
            		var array : ArrayCollection = new ArrayCollection;
            		array.source = proxy.userConnected.listeContacts
            		array.addItem(user);
            		proxy.userConnected.listeContacts = array.source;          		
            		app.mainWindow.contactView.listeContact.source = proxy.userConnected.listeContacts;
            		array = new ArrayCollection;
            		array.source = proxy.userConnected.listInvitations;
            		for(var i : Number = 0;i<array.length;i++){
            			var temp : CreateUserVO = array.getItemAt(i) as CreateUserVO;
            			if(temp.idamji_user == user.idamji_user){
            				array.removeItemAt(i);
            				break;
            			}            				
            		}
            		proxy.userConnected.listInvitations = array.source;	
            		app.mainWindow.contactView.listeInvitation.source = proxy.userConnected.listInvitations;
            		app.mainWindow.contactView.lblInvitations.value = proxy.userConnected.listInvitations.length;
            		break;      		
            }
        }    

	}
}