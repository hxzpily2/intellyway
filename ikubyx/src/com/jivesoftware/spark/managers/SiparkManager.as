/*
 *This file is part of SparkWeb.
 *
 *SparkWeb is free software: you can redistribute it and/or modify
 *it under the terms of the GNU Lesser General Public License as published by
 *the Free Software Foundation, either version 3 of the License, or
 *(at your option) any later version.
 *
 *SparkWeb is distributed in the hope that it will be useful,
 *but WITHOUT ANY WARRANTY; without even the implied warranty of
 *MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *GNU Lesser General Public License for more details.
 *
 *You should have received a copy of the GNU Lesser General Public License
 *along with SparkWeb.  If not, see <http://www.gnu.org/licenses/>.
 */

package com.jivesoftware.spark.managers
{
	import flash.xml.XMLNode;
	import mx.controls.*;	
	import mx.collections.ArrayCollection;
	import mx.rpc.http.HTTPService;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;
	import org.jivesoftware.xiff.core.XMPPConnection;
	import org.jivesoftware.xiff.core.Red5Connection;
	import org.jivesoftware.xiff.core.JID;	
	import org.jivesoftware.xiff.data.IQ;
	import org.jivesoftware.xiff.data.Presence;	
 	import org.jivesoftware.xiff.data.Message;	
	import org.jivesoftware.xiff.events.MessageEvent; 	
	import com.jivesoftware.spark.ContactListContainer;
	import com.jivesoftware.spark.StatusBox;	
 	import com.jivesoftware.spark.AlertWindow;	
 	import com.jivesoftware.spark.SipCallWindow; 	
 	import com.jivesoftware.spark.SipDialogWindow; 
 	import com.jivesoftware.spark.SipMissedCallWindow;  	
 	import com.jivesoftware.spark.ScreenWindow;   	
 	import com.jivesoftware.spark.VideoCallWindow;  
	import com.jivesoftware.spark.managers.Localizator; 	
	import org.jivesoftware.xiff.data.XMPPStanza;
	import org.jivesoftware.xiff.data.im.RosterGroup;
	import org.jivesoftware.xiff.data.sharedgroups.SharedGroupsExtension;
	import org.jivesoftware.xiff.data.sipark.SiparkExtension;
	import org.jivesoftware.xiff.data.sipark.SiparkStatus;
	import org.jivesoftware.xiff.data.disco.*;
	import org.jivesoftware.xiff.data.phone.PhoneExtension;			
	import org.jivesoftware.xiff.data.logger.LoggerExtension;		
        import org.jivesoftware.xiff.data.im.RosterItemVO;
        import org.jivesoftware.xiff.data.workgroup.AgentStatusRequestExtension;
	import org.jivesoftware.xiff.data.workgroup.AgentStatusExtension;        
	import org.jivesoftware.xiff.data.workgroup.PushURLExtension; 
    	import flash.events.*;
    	import flash.media.*;
	import flash.net.*;
	import flash.utils.*;
	import flash.external.*;
        import mx.utils.UIDUtil;	
	
	
	/**
	 * Retrieves from the server and manages locally, a list of shared groups.
	 **/
	 
	public class SiparkManager
	{
		private var connection:XMPPConnection;	
		private var incomingURL:String;

		private var isRinging:Boolean	= false;
		private var ringSound:Sound = null;
		private var ringChannel:SoundChannel = null;

		private var isDialing:Boolean = false;
		private var dialSound:Sound = null;
		private var dialChannel:SoundChannel = null;
			

		[@Embed(source="/assets/mp3/ringing.mp3")] 
		private var ringingClass:Class; 

		[@Embed(source="/assets/mp3/dialing.mp3")] 
		private var dialingClass:Class; 			
			
		public var jid:String = null;
		public var username:String;
		public var authUsername:String;
		public var displayPhoneNum:String;
		public var password:String;
		public var server:String;
		public var stunServer:String;
		public var stunPort:String;
		public var useStun:String;
		public var voicemail:String;
		public var enabled:String;
		public var outboundproxy:String;
		public var promptCredentials:String;	
		public var isReady:Boolean = false;		
		public var red5Parameters:String;
		
		public var workgroupAvailable:Boolean = false;		
		public var archiveAvailable:Boolean = false;			

		public var incomingCall:Boolean;
		public var displayName:String = "";

		private var netConnection:NetConnection = null;
		private var incomingNetStream:NetStream = null;
		private var outgoingNetStream:NetStream = null;
		private var publishName:String;
		private var playName:String;
		private var mic:Microphone = null;
		private var workgroups:Array;
		private var uid:String; 
	

		public function SiparkManager(connection:XMPPConnection):void
		{
			uid = UIDUtil.createUID();
			this.connection = connection;			

			initMicrophone();
					
			NetConnection.defaultObjectEncoding = flash.net.ObjectEncoding.AMF0;	
			netConnection = new NetConnection();
			netConnection.objectEncoding = ObjectEncoding.AMF0;
			netConnection.client = this;
			netConnection.addEventListener( NetStatusEvent.NET_STATUS , netStatus );
			netConnection.addEventListener(SecurityErrorEvent.SECURITY_ERROR, securityErrorHandler);				
			
			ringSound = new ringingClass();	
			dialSound = new dialingClass();	
			
			SparkManager.connectionManager.connection.addEventListener("message", handleMessage);			
			
		}


		public function handleMessage(event:MessageEvent):void {
			var message:Message = event.data;
		
			if (message.phoneCallerIDName != null) {
			
				if (message.phoneStatus == "RING") {
					VideoCallWindow.incoming(message, "Red5: Incoming Call");
					
					if(!isRinging) {
						ringChannel = ringSound.play();
						isRinging = true;
					}					
				}
					
				if (message.phoneStatus == "ON_PHONE") {
					VideoCallWindow.outgoing(message, "Red5: Outgoing Call");										
					
					resetSoundEffects();
				}
			}					
		}

		

		public function resetSoundEffects():void 
		{

			if(isDialing) {
				dialChannel.stop();
				isDialing = false;
			}					

			if(isRinging) {
				ringChannel.stop();
				isRinging = false;
			}			
		}
		

		public function changeVolume(value:int):void {
			var st:SoundTransform = incomingNetStream.soundTransform;

			st.volume = (value) * .01;
			incomingNetStream.soundTransform = st;		
		}

		public function changeMicVolume(value:int):void {
			mic.gain = value;
		}
			

		public function toggleMute(muted:Boolean):void {

			if(!muted) {
				if (outgoingNetStream != null) {
					outgoingNetStream.attachAudio(null);
					outgoingNetStream.publish(null);
					outgoingNetStream.close();
					outgoingNetStream = null;
				}
			}
			else {
				outgoingNetStream = new NetStream(netConnection);
				outgoingNetStream.addEventListener(NetStatusEvent.NET_STATUS, netStatus);
				outgoingNetStream.addEventListener(AsyncErrorEvent.ASYNC_ERROR, asyncErrorHandler);		
				outgoingNetStream.attachAudio(mic);
				outgoingNetStream.publish(publishName, "live");
			}
		}
			
		public function close():void 
		{
			incomingNetStream.play(false); 
			outgoingNetStream.attachAudio(null);
			outgoingNetStream.publish(null);
			
			incomingNetStream.close();
			outgoingNetStream.close();			
			netConnection.close();	
			
			setStatus("Unregistering");
		}
	
		private function initMicrophone():void {
			mic = Microphone.getMicrophone();

			if(mic == null){
				trace("No available microphone");
			} else {
				mic.setUseEchoSuppression(true);
				mic.setLoopBack(false);
				mic.setSilenceLevel(10);
				mic.gain = 60;
				mic.rate = 8;
				mic.addEventListener(ActivityEvent.ACTIVITY, micActivityHandler);
				mic.addEventListener(StatusEvent.STATUS, micStatusHandler);
			}
		}							

		private function login():void {	
			var red5URL:String = SparkManager.getConfigValueForKey("red5url");
			netConnection.connect(red5URL);
			setStatus("Registering");
		}


		private function micActivityHandler(event:ActivityEvent):void {

		}


		private function micStatusHandler(event:StatusEvent):void {		
			switch(event.code) {

			case "Microphone.Muted":
				break;
				
			case "Microphone.Unmuted":
				break;
			default:

			}
		}


		private function netStatus (evt:NetStatusEvent ):void {		    	
			switch(evt.info.code) {

			case "NetConnection.Connect.Success":			
				netConnection.call("open", null, uid, displayPhoneNum, username, password, server, outboundproxy);										
				break;

			case "NetConnection.Connect.Failed":
				break;

			case "NetConnection.Connect.Rejected":
				break;

			case "NetStream.Play.StreamNotFound":
				break;

			case "NetStream.Play.Failed":
				netConnection.call("streamStatus", null, uid, "failed");			
				break;

			case "NetStream.Play.Start":		
				netConnection.call("streamStatus", null, uid, "start");

				break;
			case "NetStream.Play.Stop":			
				netConnection.call("streamStatus", null, uid, "stop");						
				break;

			case "NetStream.Buffer.Full":
				break;

			default:

			}		    	

		}

		private function asyncErrorHandler(event:AsyncErrorEvent):void {

		}


		private function securityErrorHandler(event:SecurityErrorEvent):void {

		}


		public function callState(msg:String):* {

			if (msg == "onUaCallClosed" || msg == "onUaCallFailed") {
				incomingNetStream.play(false); 
				incomingNetStream.close();
				outgoingNetStream.attachAudio(null);
				outgoingNetStream.publish(null);
				outgoingNetStream.close();
				
				StatusBox.restore();					
				SipDialogWindow.close();
				displayName = "";
			}
			
			if (msg == "onUaCallCancelled") {
					
				if (incomingCall) {
				
					if(isRinging) {
						ringChannel.stop();
						isRinging = false;
					}	
					
					logMissedCall();					
					SipCallWindow.close();
					SipMissedCallWindow.show(displayName, incomingURL, "SIP Phone: Missed Call");
				} else 
				     SipDialogWindow.close();
				     
				displayName = "";				     
			}
		}



		public function incoming(source:String, sourceName:String, destination:String, destinationName:String):* 
		{
			SipCallWindow.show(source, sourceName, "SIP Phone: Incoming Call");
			displayName = sourceName == "" ? source : sourceName;
			incomingURL = source;
			incomingCall = true;
			
			if(!isRinging) {
				ringChannel = ringSound.play();
				isRinging = true;
			}			
		}



		public function connected(publishName:String, playName:String):* {
		
			this.publishName = publishName;
			this.playName = playName;
			
			if(isRinging) {
				ringChannel.stop();
				isRinging = false;
			}
			
			if(isDialing) {
				dialChannel.stop();
				isDialing = false;
			}			
				
			incomingNetStream = new NetStream(netConnection);
			incomingNetStream.addEventListener(NetStatusEvent.NET_STATUS, netStatus);
			incomingNetStream.addEventListener(AsyncErrorEvent.ASYNC_ERROR, asyncErrorHandler);

			outgoingNetStream = new NetStream(netConnection);
			outgoingNetStream.addEventListener(NetStatusEvent.NET_STATUS, netStatus);
			outgoingNetStream.addEventListener(AsyncErrorEvent.ASYNC_ERROR, asyncErrorHandler);			
			outgoingNetStream.attachAudio(mic);

			incomingNetStream.play(playName); 
			outgoingNetStream.publish(publishName, "live"); 
			
			StatusBox.save(3);
			SparkManager.presenceManager.changePresence(Presence.SHOW_DND, "On the Phone");			
			SipDialogWindow.show(displayName, "SIP Phone");			

		}


		public function registrationSucess(msg:String):* {
		
			setStatus("Registered");
			isReady = true;
		}


		public function registrationFailure(msg:String):* {
		
			setStatus("RegistrationFailed");
			isReady = false;
			AlertWindow.show(msg, "SIP Phone Error");
		}


		public  function pushVideoURL(jid:JID, firstParty:String, secondParty:String):void
		{
			var message:Message = new Message();
			message.type = Message.GROUPCHAT_TYPE
			message.to = jid;

			var callerParams:Array = red5Parameters.split("|");	
			var red5Name:String = callerParams[6];
			var port:String = callerParams[5];
			
			var url:String = "http://" + connection.server + ":" + port + "/" + red5Name + "/video/video320x240.html?me=" + secondParty + "&you=" + firstParty
			message.body = "Start a Video session with page " + url			
			message.addExtension(new PushURLExtension(url));			
			SparkManager.connectionManager.connection.send(message);
		}


		public  function pushDesktopURL(jid:JID, secondParty:String):void
		{
			var message:Message = new Message();
			message.type = Message.GROUPCHAT_TYPE;
			message.to = jid;

			var callerParams:Array = red5Parameters.split("|");	
			var red5Name:String = callerParams[6];
			var port:String = callerParams[5];
			
			var url:String = "http://" + connection.server + ":" + port + "/" + red5Name + "/viewer?username=" + secondParty;
			message.body = "Start a Desktop share session with page " + url
			
			message.addExtension(new PushURLExtension(url));			
			SparkManager.connectionManager.connection.send(message);
		}


		public function publishDesktop():void {

			var callerParams:Array = red5Parameters.split("|");	
			var red5Name:String = callerParams[6];

			var url:String = "/" + red5Name + "/viewer?username=" + SparkManager.connectionManager.connection.username;
				
			ExternalInterface.call("publishDesktop", url);		
		}
			


		public function viewDesktopScreen(contact:RosterItemVO, jid:JID):void {
			var user:String = jid.toString().split("@")[0];
			var callerParams:Array = red5Parameters.split("|");	
			var red5Name:String = callerParams[6];

			var url:String = "/" + red5Name;
			
			ScreenWindow.show(user, url);	
		}


		public function red5Call(contact:RosterItemVO, jid:JID):void {

			if (contact.show == "dnd" || contact.show == "away") {
				AlertWindow.show(jid.toString() + " " + Localizator.getText('label.red5.error.message'), "Red5 Call");	
				
			} else {
				red5CallDirect(jid);
			}
		
		}


		public function red5CallDirect(jid:JID):void {

			var callerParams:Array = red5Parameters.split("|");			
			var msg:Message = new Message(jid)

			var phone:PhoneExtension = new PhoneExtension();		

			phone.callType = "RING"
			phone.callDevice = "Red5"
			phone.callID = msg.id;
			phone.callerIDName = SparkManager.connectionManager.connection.username;
			phone.callerID = "ring|" + SparkManager.connectionManager.connection.jid.toString() + "|" + callerParams[0] + "|" + callerParams[1] + "|" + callerParams[2] + "|" + callerParams[3] + "|" + callerParams[4]  + "|" + callerParams[5]  + "|" + callerParams[6]

			msg.addExtension(phone);
			SparkManager.connectionManager.connection.send(msg);

			if(!isDialing) {
				dialChannel = dialSound.play(0,5);			
				isDialing = true;					
			}		
		}



		public function makeCall(destination:String):void {

			netConnection.call("call", null, uid, destination);
			displayName = destination;
			incomingCall = false;
			
			if(!isDialing) {
				dialChannel = dialSound.play(0,5);			
				isDialing = true;				
			}			
		}

		public function dtmf(chr:String):void {
			netConnection.call("dtmf", null, uid, chr);
		}

		public function clearCall():void {
			netConnection.call("hangup",  null, uid);	
			StatusBox.restore();	
			
			if(isDialing) {
				dialChannel.stop();
				isDialing = false;
			}	
			
			displayName = "";
		}		


		public function acceptCall():void {
			netConnection.call("accept",  null, uid);			
		}


		public function logCall(duration:String):void
		{
			var iq:IQ = new IQ(new JID("logger." + connection.server), IQ.SET_TYPE, XMPPStanza.generateID("set_logger_"), "_receivedLogger", this);
			iq.addExtension(new LoggerExtension(duration, displayName, displayPhoneNum, (new Date()).toString(), incomingCall ? "received" : "dialed"));
			connection.send(iq);
		}


		public function logMissedCall():void
		{
			var iq:IQ = new IQ(new JID("logger." + connection.server), IQ.SET_TYPE, XMPPStanza.generateID("set_logger_"), "_receivedLogger", this);
			iq.addExtension(new LoggerExtension("0", displayName, displayPhoneNum, (new Date()).toString(), "missed"));
			connection.send(iq);
		}

		

		public function getSettings():void
		{

			var iq0:IQ = new IQ(new JID(connection.server), IQ.GET_TYPE, XMPPStanza.generateID("get_disco_info__"), "_receivedDiscoInfo", this);
			iq0.addExtension(new InfoDiscoExtension());
			connection.send(iq0);

			var iq1:IQ = new IQ(new JID(connection.server), IQ.GET_TYPE, XMPPStanza.generateID("get_disco_items_"), "_receivedDiscoItems", this);
			iq1.addExtension(new ItemDiscoExtension());
			connection.send(iq1);

			var iq2:IQ = new IQ(new JID(connection.jid.bareJID), IQ.GET_TYPE, XMPPStanza.generateID("get_pubsub_"));
			iq2.addExtension(new InfoDiscoExtension());
			connection.send(iq2);	
			
			//var presence:Presence = new Presence();
			//presence.to = new JID(connection.jid.bareJID);
			//SparkManager.connectionManager.connection.send(presence);			
						
		}
		

		public function saveAvatar(pngString:String):void {
			
			netConnection.call("saveAvatar", null, connection.username, pngString);
			
		}

		public function setStatus(status:String):void
		{
			var iq:IQ = new IQ(new JID("sipark." + connection.server), IQ.SET_TYPE, XMPPStanza.generateID("get_siparkStatus_"), "_receivedSiparkStatus", this);
			iq.addExtension(new SiparkStatus(status));
			connection.send(iq);			
		}


		public function _receivedDiscoInfo(resultIQ:IQ):void
		{					
			var iqNode:XMLNode = resultIQ.getNode();
			
			if (!iqNode)
				return;
			
			var bAutoArchive:Boolean = false;
			var bMangeArchive:Boolean = false;
			
			var children:Array = iqNode.childNodes;

			for (var i:String in children) {

			   if (children[i].nodeName == "query") {

				var callInfo:Array = children[i].childNodes;

				for (var j:String in callInfo) {

					if (callInfo[j].nodeName == "feature") {
					
						if (callInfo[j].toString().indexOf("urn:xmpp:archive:manage") > -1) {						
							bMangeArchive = true;
						}					
					
						if (callInfo[j].toString().indexOf("urn:xmpp:archive:auto") > -1) {						
							bAutoArchive = true;
						}
					}
				}			   

			   }
			}
			
			if (bAutoArchive && bMangeArchive) {
				archiveAvailable = true;				
			}
		}


		public function _receivedDiscoItems(resultIQ:IQ):void
		{					
			var iqNode:XMLNode = resultIQ.getNode();
			
			if (!iqNode)
				return;
			
			var children:Array = iqNode.childNodes;

			for (var i:String in children) {

			   if (children[i].nodeName == "query") {

				var callInfo:Array = children[i].childNodes;

				for (var j:String in callInfo) {

					if (callInfo[j].nodeName == "item") {
					
						if (callInfo[j].attributes.jid == "sipark." + connection.server) {						
							var iq1:IQ = new IQ(new JID("sipark." + connection.server), IQ.GET_TYPE, XMPPStanza.generateID("get_sipark_"), "_receivedSipark", this);
							iq1.addExtension(new SiparkExtension());
							connection.send(iq1);											
						}
						
						if (callInfo[j].attributes.jid == "red5." + connection.server) {						
							var iq2:IQ = new IQ(new JID("red5." + connection.server), IQ.GET_TYPE, XMPPStanza.generateID("get_red5_"), "_receivedRed5", this);
							iq2.addExtension(new InfoDiscoExtension());
							connection.send(iq2);	
						}
						
						if (callInfo[j].attributes.jid == "workgroup." + connection.server) {						
							var iq3:IQ = new IQ(new JID("workgroup." + connection.server), IQ.GET_TYPE, XMPPStanza.generateID("get_workgroup_"), "_receivedWorkgroup", this);
							iq3.addExtension(new ItemDiscoExtension());
							connection.send(iq3);	
						}					
					}
				}			   

			   }
			}						
		}

		public function _receivedRed5(resultIQ:IQ):void
		{					
			var iqNode:XMLNode = resultIQ.getNode();
			
			if (!iqNode)
				return;
			
			var children:Array = iqNode.childNodes;

			for (var i:String in children) {

			   if (children[i].nodeName == "query") {

				var callInfo:Array = children[i].childNodes;

				for (var j:String in callInfo) {

					if (callInfo[j].nodeName == "identity")
						red5Parameters = callInfo[j].attributes.category;
				}			   

			   }
			}						
		}

		public function _receivedWorkgroup(resultIQ:IQ):void
		{	
			workgroupAvailable = true;			
			var iqNode:XMLNode = resultIQ.getNode();
			
			if (!iqNode)
				return;
			
			var children:Array = iqNode.childNodes;

			for (var i:String in children) {

			   if (children[i].nodeName == "query") {

				workgroups = children[i].childNodes;
				
				sendWorkgroupPresence(null, "Available");

				for (var j:String in workgroups) {
				
					if (workgroups[j].nodeName == "item") {
						var jid:JID = new JID(workgroups[j].attributes.jid);
						var iq:IQ = new IQ(jid, IQ.GET_TYPE, XMPPStanza.generateID("get_agent_status_"), "_receivedAgentStatus", this);
						iq.addExtension(new AgentStatusRequestExtension());
						connection.send(iq);							
					}						
				}

				ContactListContainer.window.showWorkgroup();				
				return;
			   }
			}				
		}
		

		public  function sendWorkgroupPresence(newShow:String, newStatus:String):void
		{

			if (workgroupAvailable) {
			
				for (var j:String in workgroups) {

					if (workgroups[j].nodeName == "item") {				
						var jid:JID = new JID(workgroups[j].attributes.jid);
						changeWorkgroupPresence(jid, newShow, newStatus);							
					}						
				}
			}
		}
		
		
		private  function changeWorkgroupPresence(jid:JID, newShow:String, newStatus:String):void
		{
			var presence:Presence = new Presence();
			presence.show = newShow;
			presence.priority = 0;
			presence.status = newStatus;
			presence.to = jid;
			
			presence.addExtension(new AgentStatusExtension());
				
			SparkManager.connectionManager.connection.send(presence);
		}



		public function _receivedAgentStatus(resultIQ:IQ):void {


			var iqNode:XMLNode = resultIQ.getNode();
			
			if (!iqNode)
				return;			
			var children:Array = iqNode.childNodes;

			for (var i:String in children) {

			   if (children[i].nodeName == "agent-status-request") {			   
			   	_processAgentStatus(children[i], resultIQ.from);			   	
			   	return;
			   }
			}
						
		}

		private function getJIDName(jid:JID):String 
		{
			var str:String = jid.toString();
			var slashIndex:int = str.lastIndexOf("@");
			
			if(slashIndex > 0)
				str = str.substring(0, slashIndex);
			return str;
		}

		private function _processAgentStatus(iqNode:XMLNode, from:JID):void 
		{
			var children:Array = iqNode.childNodes;

			for (var i:String in children) {

			   if (children[i].nodeName == "agent") {			   
				var parameters:Array = children[i].childNodes;
				var agentJID:String = children[i].attributes.jid.toString();
				
				for (var j:String in parameters) {

					if (parameters[j].nodeName == "name") {						
						SparkManager.workgroups.addContact(new JID(agentJID), parameters[j].firstChild.nodeValue, getJIDName(from));
					}
				}
						
			   }
			}			
		}

		

		public function _receivedSipark(resultIQ:IQ):void
		{			
			var iqNode:XMLNode = resultIQ.getNode();
			
			if (!iqNode)
				return;
			
			var children:Array = iqNode.childNodes;

			for (var i:String in children) {

			   if (children[i].nodeName == "phone") {
			   
			   	_processSipark(children[i]);
		   	
			   	if (jid != null) {			   	
			   		login();
			   	}			   	
			   	return;
			   }
			}						
		}

		
		
		public function _receivedSiparkStatus(resultIQ:IQ):void {
		
		
		}

		public function _receivedLogger(resultIQ:IQ):void {
		
		
		}
		

		private function onFaultHttpService(e:FaultEvent):void
		{
			AlertWindow.show(Localizator.getText('label.publish.desktop.error'), "Desktop Screen Publishing");
		}

		private function onResultHttpService(e:ResultEvent):void
		{

		}		
		
		private function _processSipark(iqNode:XMLNode):void 
		{
			var children:Array = iqNode.childNodes;

			for (var i:String in children) {

			   if (children[i].nodeName == "registration") {

				var registration:Array = children[i].childNodes;
				
				for (var j:String in registration) {

					if (registration[j].nodeName == "jid")
						jid = registration[j].firstChild.nodeValue;
						
					if (registration[j].nodeName == "username")
						username = registration[j].firstChild.nodeValue;
						
					if (registration[j].nodeName == "authUsername")
						authUsername = registration[j].firstChild.nodeValue;
						
					if (registration[j].nodeName == "displayPhoneNum")
						displayPhoneNum = registration[j].firstChild.nodeValue;

					if (registration[j].nodeName == "outboundproxy")
						outboundproxy = registration[j].firstChild.nodeValue;						
						
					if (registration[j].nodeName == "password")
						password = registration[j].firstChild.nodeValue;
						
					if (registration[j].nodeName == "server")
						server = registration[j].firstChild.nodeValue;
/*						
					if (registration[j].nodeName == "stunServer")
						stunServer = registration[j].firstChild.nodeValue;
						
					if (registration[j].nodeName == "stunPort")
						stunPort = registration[j].firstChild.nodeValue;
						
					if (registration[j].nodeName == "useStun")
						useStun = registration[j].firstChild.nodeValue;
						
					if (registration[j].nodeName == "voicemail")
						voicemail = registration[j].firstChild.nodeValue;
						
					if (registration[j].nodeName == "enabled")
						enabled = registration[j].firstChild.nodeValue;
						
					if (registration[j].nodeName == "promptCredentials")				   
						promptCredentials = registration[j].firstChild.nodeValue;
*/						
				}						
			   }
			   
			   break;
			}						
		}
						
	}
}
