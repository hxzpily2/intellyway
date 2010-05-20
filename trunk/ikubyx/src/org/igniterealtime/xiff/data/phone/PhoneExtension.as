package org.igniterealtime.xiff.data.phone{
	
	import flash.xml.XMLNode;
	
	import org.igniterealtime.xiff.data.Extension;
	import org.igniterealtime.xiff.data.IExtension;
	import org.igniterealtime.xiff.data.ISerializable;
		
	/**
	 * Implements http://jivesoftware.com/xmlns/phone namespace. 
	 */
	 
	public class PhoneExtension extends Extension implements IExtension, ISerializable
	{
		public static var NS:String = "http://jivesoftware.com/xmlns/phone";
		public static var ELEMENT:String = "phone-event";
		
		public var callType:String;
		public var callID:String;
		public var callDevice:String;
		public var callerIDName:String;
		public var callerID:String;
		
		
		public function PhoneExtension()
		{
			super(null);
		}
			
		public function getNS():String
		{
			return PhoneExtension.NS;
		}
	
		public function getElementName():String
		{
			return PhoneExtension.ELEMENT;
		}
			
		public function serialize( parentNode:XMLNode ):Boolean		
		{
			var callerIDNode:XMLNode = new XMLNode(1, 'callerID');
			callerIDNode.appendChild(new XMLNode(3, this.callerID));

			var callerIDNameNode:XMLNode = new XMLNode(1, 'callerIDName');
			callerIDNameNode.appendChild(new XMLNode(3, this.callerIDName));
			
			var xmlNode:XMLNode = new XMLNode(1, ELEMENT);			
			xmlNode.attributes.xmlns = NS;
			xmlNode.attributes.type = this.callType;
			xmlNode.attributes.callID = this.callID;
			xmlNode.attributes.device = this.callDevice;
			
			xmlNode.appendChild(callerIDNameNode);					
			xmlNode.appendChild(callerIDNode);					
			
			parentNode.appendChild(xmlNode);			
			return true;
		}
	
		public function deserialize( node:XMLNode ):Boolean
		{
			return true;
	
		}
				
	}
}