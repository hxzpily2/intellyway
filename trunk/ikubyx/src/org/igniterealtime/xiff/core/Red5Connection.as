/*
 * Copyright (C) 2003-2007 
 * Nick Velloff <nick.velloff@gmail.com>
 * Derrick Grigg <dgrigg@rogers.com>
 * Sean Voisen <sean@voisen.org>
 * Sean Treadway <seant@oncotype.dk>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA 
 *
 */
	 
package org.igniterealtime.xiff.core
{	 
	import com.jivesoftware.spark.managers.SparkManager;
	
	import flash.events.AsyncErrorEvent;
	import flash.events.NetStatusEvent;
	import flash.events.SecurityErrorEvent;
	import flash.net.NetConnection;
	import flash.xml.XMLDocument;
	import flash.xml.XMLNode;
	
	import org.igniterealtime.xiff.events.DisconnectionEvent;
	import org.igniterealtime.xiff.events.IncomingDataEvent;
	import org.igniterealtime.xiff.events.LoginEvent;
	import org.igniterealtime.xiff.events.OutgoingDataEvent;
	import org.igniterealtime.xiff.events.*;
	
	
	/**
	 * A child of <code>XMPPConnection</code>, this class makes use of the
	 * Flash RTMP connection instead of the XMLSocket</code>.
	 * 
	 * @see org.jivesoftware.xiff.core.XMPPConnection
	 */
	public class Red5Connection extends XMPPConnection
	{

		public var netConnection:NetConnection = null;
		protected var ignoreWhitespace:Boolean;
				
		public function Red5Connection()
		{
			super();						
			configureRed5();
		}
		
		private function configureRed5():void {
		
			NetConnection.defaultObjectEncoding = flash.net.ObjectEncoding.AMF0;	
			netConnection = new NetConnection();
			netConnection.client = this;
			netConnection.addEventListener( NetStatusEvent.NET_STATUS , netStatus );
			netConnection.addEventListener(SecurityErrorEvent.SECURITY_ERROR, securityErrorHandler);
	    	}
	    	

		private function netStatus (evt:NetStatusEvent ):void {		 

			switch(evt.info.code) {
				
				case "NetConnection.Connect.Success":
					active = true;	
					netConnection.call("connectXMPP", null);					
					var event:ConnectionSuccessEvent = new ConnectionSuccessEvent();
					dispatchEvent( event );									
					break;
		
				case "NetConnection.Connect.Failed":
					dispatchError( "service-unavailable", "Service Unavailable", "cancel", 503 );				
					break;
					
				case "NetConnection.Connect.Closed":
					var event2:DisconnectionEvent = new DisconnectionEvent();
					dispatchEvent( event2 );				
					break;
		
				case "NetConnection.Connect.Rejected":
					dispatchError( "not-authorized", "Not Authorized", "auth", 401 );				
					break;
					
				default:
					
			}			 
		} 
		
		private function asyncErrorHandler(event:AsyncErrorEvent):void {
           		//trace("AsyncErrorEvent: " + event);
        	}
		
		private function securityErrorHandler(event:SecurityErrorEvent):void {
            		//trace("securityErrorHandler: " + event);
        	}
        
	    
	    	override protected function sendXML( someData:* ):void
		{
			if (someData is String) {
				netConnection.call("outXML", null, someData as String);			
			} else {
				netConnection.call("outXML", null, someData.toString());
			
			}
			var event:OutgoingDataEvent = new OutgoingDataEvent();
			event.data = someData;
			dispatchEvent( event );
		}
		
		override public function disconnect():void
		{
			if( isActive() ) {
				netConnection.close();
				active = false;
				loggedIn = false;
				var event:DisconnectionEvent = new DisconnectionEvent();
				dispatchEvent(event);
			}
		}
		
		override public function connect( streamType:uint = 0 ):Boolean
		{
			active = false;
			loggedIn = false;

			var xmppUrl:String = SparkManager.getConfigValueForKey("xmppurl");
			netConnection.connect(xmppUrl);			
			return true;
		}


		public function accepted(rawXML:String):* 
		{					
			loggedIn = true;
			var event2:LoginEvent = new LoginEvent();
			dispatchEvent( event2 );
		}
		
		
		public function rejected(rawXML:String):* 
		{
			dispatchError( "not-authorized", "Not Authorized", "auth", 401 );

		}	
		
		public function get ignoreWhite():Boolean
		{
			return ignoreWhitespace;
		}
	
		public function set ignoreWhite( val:Boolean ):void
		{
			ignoreWhitespace = val;
		}	
		
		public function inXML(rawXML:String):* 
		{
			
			var xmlData:XMLDocument = new XMLDocument();
			xmlData.ignoreWhite = this.ignoreWhite;
			var isComplete:Boolean = true;

			if ("<?xml version='1.0' encoding='UTF-8'?>" == rawXML.substring(0, 38)) rawXML = rawXML.substring(38) + "</stream:stream>";
						
			try{
				//AlertWindow.show(rawXML, "raw xml");
				xmlData.parseXML( rawXML );
			}
			catch(err:Error){
				isComplete = false;
			}
			
			
			if (isComplete){				
				var event:IncomingDataEvent = new IncomingDataEvent();
				event.data = xmlData;
				dispatchEvent( event );
				
				for (var i:int = 0; i<xmlData.childNodes.length; i++)
				{
					// Read the data and send it to the appropriate parser
					var currentNode:XMLNode = xmlData.childNodes[i];
					var nodeName:String = currentNode.nodeName.toLowerCase();
										
					switch( nodeName )
					{
						case "stream:stream":							
							netConnection.call("loginXMPP", null, username, password, resource);								
							break;
							
						case "flash:stream":
							_expireTagSearch = false;
							handleStream( currentNode );
							break;
							
						case "stream:error":
							handleStreamError( currentNode );
							break;
							
						case "iq":
							handleIQ( currentNode );
							break;
							
						case "message":
							handleMessage( currentNode );
							break;
							
						case "presence":
							handlePresence( currentNode );
							break;
							
						default:
							dispatchError( "undefined-condition", "Unknown Error", "modify", 500 );
							break;
					}
				}
			}
		}
	}
}