package org.igniterealtime.xiff.data.workgroup {
	
	import flash.xml.XMLNode;
	import mx.controls.Alert;	
	import org.jivesoftware.xiff.data.Extension;
	import org.jivesoftware.xiff.data.ExtensionClassRegistry;
	import org.jivesoftware.xiff.data.IExtension;
	import org.jivesoftware.xiff.data.ISerializable;
		
	/**
	 * Implements http://jabber.org/protocol/workgroup
	 */
	 
	public class OfferRejectExtension extends Extension implements IExtension, ISerializable
	{
		public static var NS:String = "http://jabber.org/protocol/workgroup";
		public static var ELEMENT:String = "offer-reject";

		private var offerJID:String;				
		
		public function OfferRejectExtension(offerJID:String)
		{
			this.offerJID = offerJID;		
			super(null);
		}
			
		public function getNS():String
		{
			return OfferRejectExtension.NS;
		}
	
		public function getElementName():String
		{
			return OfferRejectExtension.ELEMENT;
		}
			
		public function serialize( parentNode:XMLNode ):Boolean		
		{
			var xmlNode:XMLNode = new XMLNode(1, ELEMENT);			
			xmlNode.attributes.xmlns = NS;	
			xmlNode.attributes.jid = offerJID;			
			parentNode.appendChild(xmlNode);			
			return true;
		}
	
		public function deserialize( node:XMLNode ):Boolean
		{
			return true;
	
		}
				
	}
}