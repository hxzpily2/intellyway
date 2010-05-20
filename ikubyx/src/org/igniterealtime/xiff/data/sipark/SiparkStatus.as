package org.igniterealtime.xiff.data.sipark{
	
	import flash.xml.XMLNode;
	import mx.controls.Alert;	
	import org.jivesoftware.xiff.data.Extension;
	import org.jivesoftware.xiff.data.ExtensionClassRegistry;
	import org.jivesoftware.xiff.data.IExtension;
	import org.jivesoftware.xiff.data.ISerializable;
		
	/**
	 * Implements http://www.jivesoftware.com/protocol/sipark namespace. 
	 */
	 
	public class SiparkStatus extends Extension implements IExtension, ISerializable
	{
		public static var NS:String = "http://www.jivesoftware.com/protocol/sipark";
		public static var ELEMENT:String = "phone";
		private var status:String = "Registered";
	

		public function SiparkStatus(status:String)
		{
			super(null);
			this.status = status;
		}
			
		public function getNS():String
		{
			return SiparkStatus.NS;
		}
	
		public function getElementName():String
		{
			return SiparkStatus.ELEMENT;
		}
			
		public function serialize( parentNode:XMLNode ):Boolean		
		{
			var statusNode:XMLNode = new XMLNode(1, 'status');
			statusNode.appendChild(new XMLNode(3, this.status));
			
			var xmlNode:XMLNode = new XMLNode(1, ELEMENT);			
			xmlNode.attributes.xmlns = NS;
			xmlNode.appendChild(statusNode);					
			
			parentNode.appendChild(xmlNode);			
			return true;
		}
	
		public function deserialize( node:XMLNode ):Boolean
		{
			return true;
	
		}
				
	}
}