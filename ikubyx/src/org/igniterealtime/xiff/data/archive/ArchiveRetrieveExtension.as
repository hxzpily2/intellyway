package org.igniterealtime.xiff.data.archive {
	
	import flash.xml.XMLNode;	
	import org.jivesoftware.xiff.data.Extension;
	import org.jivesoftware.xiff.data.IExtension;
	import org.jivesoftware.xiff.data.ISerializable;
	import org.jivesoftware.xiff.core.JID;	
		
	/**
	 * Implements urn:xmpp:archive
	 */
	 
	public class ArchiveRetrieveExtension extends Extension implements IExtension, ISerializable
	{
		public static var NS:String = "urn:xmpp:archive";
		public static var ELEMENT:String = "retrieve";
		private var jid:String;
		private var collection:String;
		
		public function ArchiveRetrieveExtension(jid:String, collection:String)
		{
			super(null);
			this.jid = jid;
			this.collection = collection;
		}
			
		public function getNS():String
		{
			return ArchiveRetrieveExtension.NS;
		}
	
		public function getElementName():String
		{
			return ArchiveRetrieveExtension.ELEMENT;
		}
			
		public function serialize( parentNode:XMLNode ):Boolean		
		{
			var xmlNode:XMLNode = new XMLNode(1, ELEMENT);			
			xmlNode.attributes.xmlns = NS;
			xmlNode.attributes["with"] = jid;
			xmlNode.attributes["start"] = collection;

			//var setNode:XMLNode = new XMLNode(1, "set");			
			//setNode.attributes.xmlns = "http://jabber.org/protocol/rsm";

			//var maxNode:XMLNode = new XMLNode(1, "max");
			//maxNode.appendChild(new XMLNode(3, listSize));

			//setNode.appendChild(maxNode);			
			//xmlNode.appendChild(setNode);			
			
			parentNode.appendChild(xmlNode);			
			return true;
		}
	
		public function deserialize( node:XMLNode ):Boolean
		{
			return true;
	
		}
				
	}
}

