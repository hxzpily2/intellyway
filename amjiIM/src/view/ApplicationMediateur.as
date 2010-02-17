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
	import model.vo.TypeVO;
	
	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	import mx.managers.PopUpManager;
	import mx.messaging.events.MessageEvent;
	import mx.messaging.messages.AsyncMessage;
	
	import org.puremvc.as3.interfaces.IMediator;
	import org.puremvc.as3.interfaces.INotification;
	import org.puremvc.as3.patterns.mediator.Mediator;
	
	import view.contacts.SearchContact;
	
	import weborb.messaging.WeborbConsumer;
	
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
			app.mainWindow.contactView.addEventListener(Actions.STATUTCHANGE,changeStatut);
			app.mainWindow.contactView.addEventListener(Actions.PSEUDOCHANGE,pseudoChange);
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
        	PopUpManager.addPopUp(app.loader,app.searchContactWin,true);
			PopUpManager.centerPopUp(app.loader);   
        	facade.sendNotification(Actions.GENERICUSER,inviteVO,Actions.ADDCONTACT);
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
			this.sendStatutChangeMessage(app.mainWindow.contactView.comboBox.selectedItem.key);
		}	
		
		public function pseudoChange(event : Event):void{
			sendNotification(Actions.GENERICUSER,app.mainWindow.contactView.txtPseudo.text,Actions.PSEUDOCHANGE);
			this.sendPseudoChangeMessage(app.mainWindow.contactView.txtPseudo.text);
		}
		
		public function sendStatutChangeMessage(statut : String):void{
			var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
			var body : Object = new Object;
			body.action = Actions.STATUTCHANGE;
			body.statut = statut;
			body.user = proxy.userConnected.userVO.idamji_user;
			
			var message : AsyncMessage = new AsyncMessage;
			message.body = body;
			app.producer.producerId = proxy.userConnected.userVO.idamji_user.toString();
			app.producer.subqueue = "user"+proxy.userConnected.userVO.idamji_user.toString();
			app.producer.send(message);
		}
		
		public function sendPseudoChangeMessage(pseudo : String):void{
			var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
			var body : Object = new Object;
			body.action = Actions.PSEUDOCHANGE;
			body.pseudo = pseudo;
			body.user = proxy.userConnected.userVO.idamji_user;
			
			var message : AsyncMessage = new AsyncMessage;
			message.body = body;
			app.producer.producerId = proxy.userConnected.userVO.idamji_user.toString();
			app.producer.subqueue = "user"+proxy.userConnected.userVO.idamji_user.toString();
			app.producer.send(message);
		}
		
		public function subscribeToChat():void{
			var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
			app.consumer.subqueue = proxy.userConnected.userVO.email;
			app.consumer.addEventListener(MessageEvent.MESSAGE,showMessage);
			app.consumer.subscribe();			
		}
		
		public function showMessage(event:MessageEvent):void{
			
		}
		
		public function topicMessage(event : MessageEvent):void{
			
		}
		
		public function contactMessage(event : MessageEvent):void{
			
		}
		
		public function createConsumerForType():void{
			var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
			for(var i : Number = 0;i<proxy.userConnected.listTypes.length;i++){
				(proxy.userConnected.listTypes[i] as TypeVO).consumer = new WeborbConsumer();
				(proxy.userConnected.listTypes[i] as TypeVO).consumer.destination = "AmjiChat";
				(proxy.userConnected.listTypes[i] as TypeVO).consumer.subqueue = "topic"+(proxy.userConnected.listTypes[i] as TypeVO).idtype.toString();
				(proxy.userConnected.listTypes[i] as TypeVO).consumer.addEventListener(MessageEvent.MESSAGE,topicMessage);
				(proxy.userConnected.listTypes[i] as TypeVO).consumer.subscribe();				 
			}
		}
		
		public function createConsumerForContacts():void{
			var proxy : ApplicationProxy = facade.retrieveProxy(ApplicationProxy.NAME) as ApplicationProxy;
			for(var i : Number = 0;i<proxy.userConnected.listeContacts.length;i++){
				(proxy.userConnected.listeContacts[i] as CreateUserVO).consumer = new WeborbConsumer();
				(proxy.userConnected.listeContacts[i] as CreateUserVO).consumer.destination = "AmjiChat";
				(proxy.userConnected.listeContacts[i] as CreateUserVO).consumer.subqueue = "user"+(proxy.userConnected.listeContacts[i] as CreateUserVO).idamji_user.toString();
				(proxy.userConnected.listeContacts[i] as CreateUserVO).consumer.addEventListener(MessageEvent.MESSAGE,contactMessage);
				(proxy.userConnected.listeContacts[i] as CreateUserVO).consumer.subscribe();				 
			}
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
            		this.subscribeToChat();
            		this.createConsumerForType();
            		app.mainWindow.contactView.lblInvitations.value = proxy.userConnected.listInvitations.length; 
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