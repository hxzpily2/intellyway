package org.igniterealtime.xiff.data.sipark{
	
	import flash.xml.XMLNode;
	
	import org.jivesoftware.xiff.data.Extension;
	import org.jivesoftware.xiff.data.ExtensionClassRegistry;
	import org.jivesoftware.xiff.data.IExtension;
	import org.jivesoftware.xiff.data.ISerializable;
		
	/**
	 * Implements http://www.jivesoftware.com/protocol/sipark namespace. 
	 */
	 
	public class SiparkExtension extends Extension implements IExtension, ISerializable
	{
		public static var NS:String = "http://www.jivesoftware.com/protocol/sipark";
		public static var ELEMENT:String = "phone";
	
		
		public function SiparkExtension( parent:XMLNode=null )
		{
			super(parent);
		}
	
		public function getNS():String
		{
			return SiparkExtension.NS;
		}
	
		public function getElementName():String
		{
			return SiparkExtension.ELEMENT;
		}
	
		
		public function serialize( parentNode:XMLNode ):Boolean		
		{
			var xmlNode:XMLNode = new XMLNode(1, getElementName() + " xmlns='" + getNS() + "'");
			parentNode.appendChild(xmlNode);		
			return true;
		}
	
		public function deserialize( node:XMLNode ):Boolean
		{
			return true;
	
		}
				
	}
}