package org.igniterealtime.xiff.data.pubsub {
	
	import flash.xml.XMLNode;	
	import org.jivesoftware.xiff.data.Extension;
	import org.jivesoftware.xiff.data.IExtension;
	import org.jivesoftware.xiff.data.ISerializable;
		
	/**
	 * Implements http://jabber.org/protocol/workgroup
	 */
	 
	public class PEPExtension extends Extension implements IExtension, ISerializable
	{
		public static var NS:String = "http://jabber.org/protocol/pubsub";
		public static var ELEMENT:String = "pubsub";
		private var node:XMLNode;
		
		public function PEPExtension(node:XMLNode)
		{
			super(null);
			this.node = node;
		}
			
		public function getNS():String
		{
			return PEPExtension.NS;
		}
	
		public function getElementName():String
		{
			return PEPExtension.ELEMENT;
		}
			
		public function serialize( parentNode:XMLNode ):Boolean		
		{
			var xmlNode:XMLNode = new XMLNode(1, ELEMENT);			
			xmlNode.attributes.xmlns = NS;
			
			xmlNode.appendChild(node);
			
			parentNode.appendChild(xmlNode);			
			return true;
		}
	
		public function deserialize( node:XMLNode ):Boolean
		{
			return true;
	
		}
				
	}
}