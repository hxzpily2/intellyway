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
	 
	public class AgentStatusRequestExtension extends Extension implements IExtension, ISerializable
	{
		public static var NS:String = "http://jabber.org/protocol/workgroup";
		public static var ELEMENT:String = "agent-status-request";
				
		
		public function AgentStatusRequestExtension()
		{
			super(null);
		}
			
		public function getNS():String
		{
			return AgentStatusRequestExtension.NS;
		}
	
		public function getElementName():String
		{
			return AgentStatusRequestExtension.ELEMENT;
		}
			
		public function serialize( parentNode:XMLNode ):Boolean		
		{
			var xmlNode:XMLNode = new XMLNode(1, ELEMENT);			
			xmlNode.attributes.xmlns = NS;			
			parentNode.appendChild(xmlNode);			
			return true;
		}
	
		public function deserialize( node:XMLNode ):Boolean
		{
			return true;
	
		}
				
	}
}