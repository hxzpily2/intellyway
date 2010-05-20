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
	 
	public class PushURLExtension extends Extension implements IExtension, ISerializable
	{
		public static var NS:String = "http://www.jivesoftware.com/xmlns/xmpp/properties";
		public static var ELEMENT:String = "properties";
		private var url:String;
		
		public function PushURLExtension(url:String)
		{
			super(null);
			this.url = url
		}
			
		public function getNS():String
		{
			return PushURLExtension.NS;
		}
	
		public function getElementName():String
		{
			return PushURLExtension.ELEMENT;
		}
			
		public function serialize( parentNode:XMLNode ):Boolean		
		{
			var xmlNode:XMLNode = new XMLNode(1, ELEMENT);			
			xmlNode.attributes.xmlns = NS;
			
			var xmlNode2:XMLNode = new XMLNode(1, "property");
			
			var xmlNode3:XMLNode = new XMLNode(1, "name");
			xmlNode3.appendChild(new XMLNode(3, "PUSH_URL"));

			var xmlNode4:XMLNode = new XMLNode(1, "value");
			xmlNode4.attributes.type = "string";
			xmlNode4.appendChild(new XMLNode(3, url));			
			
			xmlNode2.appendChild(xmlNode3);
			xmlNode2.appendChild(xmlNode4);
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