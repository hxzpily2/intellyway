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
	 
	public class AgentStatusExtension extends Extension implements IExtension, ISerializable
	{
		public static var NS:String = "http://jabber.org/protocol/workgroup";
		public static var ELEMENT:String = "agent-status";
				
		
		public function AgentStatusExtension()
		{
			super(null);
		}
			
		public function getNS():String
		{
			return AgentStatusExtension.NS;
		}
	
		public function getElementName():String
		{
			return AgentStatusExtension.ELEMENT;
		}
			
		public function serialize( parentNode:XMLNode ):Boolean		
		{
			var xmlNode:XMLNode = new XMLNode(1, ELEMENT);			
			xmlNode.attributes.xmlns = NS;
			
			var xmlNode2:XMLNode = new XMLNode(1, "max-chats");
			xmlNode2.appendChild(new XMLNode(3, "7"));
			xmlNode.appendChild(xmlNode2);
			
			parentNode.appendChild(xmlNode);			
			return true;
		}
	
		public function deserialize( node:XMLNode ):Boolean
		{
			return true;
	
		}
				
	}
}