package org.igniterealtime.xiff.data.archive {
	
	import flash.xml.XMLNode;	
	import org.jivesoftware.xiff.data.Extension;
	import org.jivesoftware.xiff.data.IExtension;
	import org.jivesoftware.xiff.data.ISerializable;
	import org.jivesoftware.xiff.core.JID;	
		
	/**
	 * Implements urn:xmpp:archive
	 */
	 
	public class ArchiveListExtension extends Extension implements IExtension, ISerializable
	{
		public static var NS:String = "urn:xmpp:archive";
		public static var ELEMENT:String = "list";
		private var jid:JID;
		private var listSize:String;
		
		public function ArchiveListExtension(jid:JID, listSize:String)
		{
			super(null);
			this.jid = jid;
			this.listSize = listSize;
		}
			
		public function getNS():String
		{
			return ArchiveListExtension.NS;
		}
	
		public function getElementName():String
		{
			return ArchiveListExtension.ELEMENT;
		}
			
		public function serialize( parentNode:XMLNode ):Boolean		
		{
			var xmlNode:XMLNode = new XMLNode(1, ELEMENT);			
			xmlNode.attributes.xmlns = NS;
			xmlNode.attributes["with"] = jid.toBareJID();

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