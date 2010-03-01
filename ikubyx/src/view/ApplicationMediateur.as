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
	
	import org.igniterealtime.xiff.conference.Room;
	import org.igniterealtime.xiff.core.EscapedJID;
	import org.igniterealtime.xiff.core.UnescapedJID;
	import org.igniterealtime.xiff.data.IQ;
	import org.igniterealtime.xiff.data.Message;
	import org.igniterealtime.xiff.data.Presence;
	import org.igniterealtime.xiff.data.XMPPStanza;
	import org.igniterealtime.xiff.data.events.MessageEventExtension;
	import org.igniterealtime.xiff.data.im.RosterExtension;
	import org.igniterealtime.xiff.events.ConnectionSuccessEvent;
	import org.igniterealtime.xiff.events.DisconnectionEvent;
	import org.igniterealtime.xiff.events.LoginEvent;
	import org.igniterealtime.xiff.events.MessageEvent;
	import org.igniterealtime.xiff.events.PresenceEvent;
	import org.igniterealtime.xiff.events.RoomEvent;
	import org.igniterealtime.xiff.events.RosterEvent;
	import org.igniterealtime.xiff.events.XIFFErrorEvent;
	import org.igniterealtime.xiff.im.Roster;
	import org.puremvc.as3.interfaces.IMediator;
	import org.puremvc.as3.interfaces.INotification;
	import org.puremvc.as3.patterns.mediator.Mediator;
	
	import view.contacts.ItemContactRenderer;
	import view.contacts.SearchContact;
	
	
	
	public class ApplicationMediateur extends Mediator implements IMediator
	{
		public static const NAME:String = 'ApplicationMediateur'; 
		private var chats:Object = {};
		private var queuedRooms:Array = [];
		public var statutdic :  Dictionary = new Dictionary();
		public var presencestatu :  Dictionary = new Dictionary();
		
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
			
			
			presencestatu[null] = Constantes.ENLIGNE;
			presencestatu[Presence.TYPE_UNAVAILABLE] = Constantes.HORSLIGNE;
			presencestatu[Presence.SHOW_AWAY] = Constantes.ABSENT;
			presencestatu[Presence.SHOW_XA] = Constantes.DERETOUR;
			presencestatu[Presence.SHOW_DND] = Constantes.OCCUPE;
			
					
			
			ApplicationFacade.getInstance().mainRoster = new Roster(ApplicationFacade.getConnexion());
    		ApplicationFacade.getInstance().mainRoster.addEventListener(RosterEvent.ROSTER_LOADED, onRoster);
    		ApplicationFacade.getInstance().mainRoster.addEventListener(RosterEvent.SUBSCRIPTION_DENIAL, onRoster);
    		ApplicationFacade.getInstance().mainRoster.addEventListener(RosterEvent.SUBSCRIPTION_REQUEST, onRoster);
    		ApplicationFacade.getInstance().mainRoster.addEventListener(RosterEvent.SUBSCRIPTION_REVOCATION, onRoster);
    		ApplicationFacade.getInstance().mainRoster.addEventListener(RosterEvent.USER_AVAILABLE, onRoster);
    		ApplicationFacade.getInstance().mainRoster.addEventListener(RosterEvent.USER_UNAVAILABLE, onRoster);
    		ApplicationFacade.getInstance().mainRoster.addEventListener(RosterEvent.USER_PRESENCE_UPDATED, onRoster);
    		
    		ApplicationFacade.getConnexion().addEventListener(PresenceEvent.PRESENCE, onPresence);
    		/*ApplicationFacade.getInstance().inviteListener = new InviteListener();
    		ApplicationFacade.getInstance().inviteListener.addEventListener(InviteEvent.INVITED,invited);*/    		
    		    		
		}
		
		
		public function onPresence(event : PresenceEvent):void{
			var len:uint = event.data.length;
            for (var i:uint = 0; i < len; ++i)
            {
                var presence:Presence = event.data[i] as Presence;
                trace("onPresence. " + i + " show: " + presence.show);
                trace("onPresence. " + i + " type: " + presence.type);
                trace("onPresence. " + i + " status: " + presence.status);
                trace("onPresence. " + i + " from: " + presence.from);
                trace("onPresence. " + i + " to: " + presence.to);
               
                switch (presence.type)
                {
                    case Presence.TYPE_SUBSCRIBE :
                        // Automatically add all those to _roster whom have requested to be our friend.
                        ApplicationFacade.getInstance().mainRoster.grantSubscription(presence.from.unescaped, true);
                        break;
                    case Presence.TYPE_SUBSCRIBED :
                        break;
                    case Presence.SHOW_AWAY :
                    	this.updateStatutContact(presence.from.unescaped,presence.type);
                        break;
                   	case Presence.SHOW_CHAT :
                   		this.updateStatutContact(presence.from.unescaped,presence.type);
                        break;
                    case Presence.SHOW_DND:
                    	this.updateStatutContact(presence.from.unescaped,presence.type);
                    	break;
                   	case Presence.SHOW_XA:
                   		this.updateStatutContact(presence.from.unescaped,presence.type);
                    	break;
                    case Presence.TYPE_UNAVAILABLE:
                    	this.updateStatutContact(presence.from.unescaped,presence.type);
                    	break;
                }
            }			
		}
		
		public function updateStatutContact(jid : UnescapedJID,presenceS : String):void{			
        	var user : CreateUserVO = isInContactList(jid.bareJID);
        	var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
        	var array : ArrayCollection = new ArrayCollection(proxy.userConnected.listeContacts);
        	var itemContact : ItemContactRenderer = this.getItemContact(user.idamji_user.toString());	            	
        	if(itemContact!=null)
        		itemContact.imgStatut.source = itemContact.statut[presencestatu[presenceS]];
        	if(user!=null){
        		for(var i : Number = 0;i<array.length;i++){
        			var temp : CreateUserVO = array.getItemAt(i) as CreateUserVO;
        			if(user.idamji_user == temp.idamji_user){	            				
        				temp.connstatut = presencestatu[presenceS];
        				array.removeItemAt(i);
        				array.addItemAt(temp,i);
        				break;	
        			}	            			
        		}
        	}
        	proxy.userConnected.listeContacts = array.source;   			 
		}
		
		public function isInTheRoster(jid : String):Boolean{
			for(var i : Number = 0;i<ApplicationFacade.getInstance().mainRoster.length;i++){
				if(ApplicationFacade.getInstance().mainRoster.getItemAt(i)==jid){
					return true;
				}
			}
			return false;
		}
		
		
		private function onRoster(event:RosterEvent):void {		
	         trace("onRoster. " + event.toString());        
	         
	        switch (event.type){
	        	case RosterEvent.ROSTER_LOADED:
	        		Alert.show(ApplicationFacade.getInstance().mainRoster.length.toString());
	        		break;
	            case RosterEvent.SUBSCRIPTION_REQUEST:
	            	ApplicationFacade.getInstance().mainRoster.grantSubscription(event.jid, true);
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
	            	var presence : String = event.data.show;
	            	var user : CreateUserVO = isInContactList(event.jid.bareJID);
	            	var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
	            	var array : ArrayCollection = new ArrayCollection(proxy.userConnected.listeContacts);
	            	var itemContact : ItemContactRenderer = this.getItemContact(user.idamji_user.toString());	            	
	            	if(itemContact!=null)
	            		itemContact.imgStatut.source = itemContact.statut[presencestatu[presence]];
	            	if(user!=null){
	            		for(var i : Number = 0;i<array.length;i++){
	            			var temp : CreateUserVO = array.getItemAt(i) as CreateUserVO;
	            			if(user.idamji_user == temp.idamji_user){	            				
	            				temp.connstatut = presencestatu[presence];
	            				array.removeItemAt(i);
	            				array.addItemAt(temp,i);
	            				break;	
	            			}	            			
	            		}
	            	}
	            	proxy.userConnected.listeContacts = array.source;            			            		            	
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
		
		public function get app():ikubyx{  
            return viewComponent as ikubyx;  
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
        	ApplicationFacade.getConnexion().disconnect();
			facade.sendNotification(Actions.GENERICUSER,null,Actions.LOGOUTCLOSE);
			app.showLoader();
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
			if(statut!=Constantes.HORSLIGNE){		
				ApplicationFacade.getPresenceManager().changePresence(statutdic[statut],statutdic[statut]);								
			}
			else{
				var recipient:EscapedJID = new EscapedJID(ApplicationFacade.getConnexion().server);
				var unavailablePresence:Presence = new Presence(recipient, null, Presence.TYPE_UNAVAILABLE, null, "Logged out");
				ApplicationFacade.getConnexion().send(unavailablePresence);				
			}
		}
		
		public function sendPseudoChangeMessage(pseudo : String):void{
			
		}	
		
		private function handleConnection( event:ConnectionSuccessEvent ):void
	    {
							
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
	    		case Actions.ACCEPTINVITATION:
	    			facade.sendNotification(Actions.GENERICUSER,message.body,Actions.GETINFOUSER);  			
					break;
	    	}
	    }
	    
	    
	    public function updateSubscribeContact(jid : EscapedJID,type : String):void{
	    	var tempIQ:IQ = new IQ( null, IQ.TYPE_SET, XMPPStanza.generateID( "update_contact_" ) );
			var ext:RosterExtension = new RosterExtension( tempIQ.getNode() );
			ext.addItem( jid, type );
			tempIQ.addExtension( ext );
			ApplicationFacade.getConnexion().send(tempIQ);
	    }
	    
	    public function inviteContact(jid : UnescapedJID):void{
	    	var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
			var message:Message = new Message(jid.escaped);
			message.addExtension(new MessageEventExtension());
			message.from = new EscapedJID(Commun.getJidFromMail(proxy.userConnected.userVO.email)+"@"+Constantes.XMPPSERVEUR);			
			message.subject = Actions.INVITECONTACT;
			message.type = Message.TYPE_CHAT;		
			ApplicationFacade.getConnexion().send(message);	
	    }
	    
	    public function sendXMPPAcceptContact(jid : UnescapedJID):void{
	    	var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
			var message:Message = new Message(jid.escaped);
			message.addExtension(new MessageEventExtension());
			message.from = new EscapedJID(Commun.getJidFromMail(proxy.userConnected.userVO.email)+"@"+Constantes.XMPPSERVEUR);			
			message.subject = Actions.ACCEPTINVITATION;
			message.type = Message.TYPE_CHAT;
			message.body = proxy.userConnected.userVO.email;		
			ApplicationFacade.getConnexion().send(message);	
	    }
	    
	    public function sendXMPPNotif(jid : UnescapedJID,type : String,body :String):void{
	    	var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
			var message:Message = new Message(jid.escaped);
			message.addExtension(new MessageEventExtension());
			message.from = new EscapedJID(Commun.getJidFromMail(proxy.userConnected.userVO.email)+"@"+Constantes.XMPPSERVEUR);			
			message.subject = type;
			message.type = Message.TYPE_CHAT;
			message.body = body;		
			ApplicationFacade.getConnexion().send(message);	
	    }		
		
		override public function listNotificationInterests():Array  
        {  
            return [  
              	Actions.CREATAUSER,ApplicationFacade.LOGINFAILED,ApplicationFacade.LOGINSUCCESS,ApplicationFacade.INSCRSUCCESS,
              	ApplicationFacade.SEARCHSUCCESS,ApplicationFacade.INVITESUCCESS,ApplicationFacade.INVITEFAILED,
              	ApplicationFacade.IGNORECONTACT,ApplicationFacade.ACCEPTCONTACT,ApplicationFacade.GETINFOUSERSUCCESS,
              	ApplicationFacade.LOGOUTSUCCESS
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
            		
            		app.mainWindow.contactView.lblInvitations.value = proxy.userConnected.listInvitations.length;
            		app.mainWindow.contactView.listeInvitation.source = proxy.userConnected.listInvitations;
            		this.loginXMPP();            		            		
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
            		ApplicationFacade.getInstance().mainRoster.addContact(new UnescapedJID(Commun.getJidFromMail((proxy.listeSearchContact[app.searchContactWin.listContact.selectedIndex] as CreateUserVO).email)+"@"+Constantes.XMPPSERVEUR+"/"+Constantes.XMPPRESOURCE),Commun.getJidFromMail((proxy.listeSearchContact[app.searchContactWin.listContact.selectedIndex] as CreateUserVO).email),null,true);
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
            		app.mainWindow.contactView.window.listeInvitation.source = proxy.userConnected.listInvitations;
            		break;
            	case ApplicationFacade.ACCEPTCONTACT:            		
            		var user : CreateUserVO = notification.getBody() as CreateUserVO;
            		ApplicationFacade.getInstance().mainRoster.addContact(new UnescapedJID(Commun.getJidFromMail(user.email)+"@"+Constantes.XMPPSERVEUR+"/"+Constantes.XMPPRESOURCE),new UnescapedJID(Commun.getJidFromMail(user.email)).toString(),null,true);
            		this.sendXMPPAcceptContact(new UnescapedJID(Commun.getJidFromMail(user.email)+"@"+Constantes.XMPPSERVEUR));            		
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
            		app.mainWindow.contactView.window.listeInvitation.source = proxy.userConnected.listInvitations;
            		app.mainWindow.contactView.lblInvitations.value = proxy.userConnected.listInvitations.length;
            		break;
            	case ApplicationFacade.GETINFOUSERSUCCESS:
            		var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
            		var user : CreateUserVO = notification.getBody() as CreateUserVO;
            		var array : ArrayCollection = new ArrayCollection;
            		array.source = proxy.userConnected.listeContacts; 
            		for(var i : Number = 0;i<array.length;i++){
            			var cuser : CreateUserVO = array.getItemAt(i) as CreateUserVO;
            			if(cuser.idamji_user == user.idamji_user){
            				array.removeItemAt(i);
            				array.addItemAt(user,i);
            				break;
            			}
            		}            		
            		proxy.userConnected.listeContacts = array.source;
            		app.mainWindow.contactView.listeContact.source = proxy.userConnected.listeContacts;
            		break;
            	case ApplicationFacade.LOGOUTSUCCESS:            		
            		app.closeHandler();
            		break;      		
            }
        }
        
        public function isInContactList(jid : String):CreateUserVO{
			var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
			var array : ArrayCollection = new ArrayCollection;
			array.source = proxy.userConnected.listeContacts;
			for(var i: Number=0;i<array.length;i++){
				var user:CreateUserVO = array.getItemAt(i) as CreateUserVO;			
				if(Commun.getJidFromMail(user.email)+"@"+Constantes.XMPPSERVEUR==jid){
					return user;
				}	
			}
			return null;		
		}
		
		public function isInInviteList(jid : String):Boolean{
			var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
			var array : ArrayCollection = new ArrayCollection;
			array.source = proxy.userConnected.listInvitations;
			for(var i: Number=0;i<array.length;i++){
				var user:CreateUserVO = array.getItemAt(i)  as CreateUserVO;			
				if(Commun.getJidFromMail(user.email)+"@"+Constantes.XMPPSERVEUR==jid){
					return true;
				}	
			}
			return false;
		}  
		
		
		public function loginXMPP():void{
			ApplicationFacade.getConnexion().addEventListener( LoginEvent.LOGIN, handleLogin );
  			ApplicationFacade.getConnexion().addEventListener( XIFFErrorEvent.XIFF_ERROR, handleError );
  			ApplicationFacade.getConnexion().addEventListener( DisconnectionEvent.DISCONNECT, handleDisconnect );
  			
  			ApplicationFacade.getConnexion().server = Constantes.XMPPSERVEUR;
  			ApplicationFacade.getConnexion().useAnonymousLogin = false;      			
  			ApplicationFacade.getConnexion().username = Constantes.XMPPUSERPREFIX+app.window.userVO.login.substr(0,app.window.userVO.login.lastIndexOf("@"))+Commun.getDomainFromMail(app.window.userVO.login);
      		ApplicationFacade.getConnexion().password = app.window.userVO.pass;
			ApplicationFacade.getConnexion().connect();				
			// register login && password && statut
		}
		
				
		private function handleLogin( event:LoginEvent ):void
	    {
	      	ApplicationFacade.getConnexion().addEventListener(MessageEvent.MESSAGE,handleMessage);
	      	if(app.window.comboBox.selectedItem.key!=Constantes.HORSLIGNE){		
				ApplicationFacade.getPresenceManager().changePresence(statutdic[app.window.comboBox.selectedItem.key],statutdic[app.window.comboBox.selectedItem.key]);								
			}
			else{
				var recipient:EscapedJID = new EscapedJID(ApplicationFacade.getConnexion().server);
				var unavailablePresence:Presence = new Presence(recipient, null, Presence.TYPE_UNAVAILABLE, null, "Logged out");
				ApplicationFacade.getConnexion().send(unavailablePresence);				
			}		      		      
	    }
	    
	    public function getItemContact(key : String):ItemContactRenderer{	    	
	    	for(var i : Number=0;i<app.mainWindow.contactView.itemContact.length;i++){
	    		var item : ItemContactRenderer = app.mainWindow.contactView.itemContact[i];	    		   		
	    		if(item.key==key)
	    			return item;	    		
	    	}
	    	return null;	    	
	    }  

	}
	
	
		
}