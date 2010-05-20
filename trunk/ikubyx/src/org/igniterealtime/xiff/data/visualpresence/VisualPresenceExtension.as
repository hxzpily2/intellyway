package org.igniterealtime.xiff.data.visualpresence{
	
	import flash.xml.XMLNode;
	import mx.controls.Alert;	
	import org.jivesoftware.xiff.data.Extension;
	import org.jivesoftware.xiff.data.ExtensionClassRegistry;
	import org.jivesoftware.xiff.data.IExtension;
	import org.jivesoftware.xiff.data.ISerializable;
		
	/**
	 * Implements http://jivesoftware.com/xmlns/phone namespace. 
	 */
	 
	public class VisualPresenceExtension extends Extension implements IExtension, ISerializable
	{
		public static var NS:String = "http://www.igniterealtime.org/xmlns/visual-presence";
		public static var ELEMENT:String = "visual-presence";
		
		public var visualPresence:String;
		
		
		public function VisualPresenceExtension()
		{
			super(null);
		}
			
		public function getNS():String
		{
			return VisualPresenceExtension.NS;
		}
	
		public function getElementName():String
		{
			return VisualPresenceExtension.ELEMENT;
		}
			
		public function serialize( parentNode:XMLNode ):Boolean		
		{
			var xmlNode:XMLNode = new XMLNode(1, ELEMENT);			
			xmlNode.attributes.xmlns = NS;
			xmlNode.appendChild(new XMLNode(3, this.visualPresence));												
			parentNode.appendChild(xmlNode);			
			return true;
		}
	
		public function deserialize( node:XMLNode ):Boolean
		{
			return true;
	
		}
				
	}
}