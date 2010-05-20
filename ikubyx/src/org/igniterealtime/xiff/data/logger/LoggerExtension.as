package org.igniterealtime.xiff.data.logger{
	
	import flash.xml.XMLNode;
	import mx.controls.Alert;	
	import org.jivesoftware.xiff.data.Extension;
	import org.jivesoftware.xiff.data.ExtensionClassRegistry;
	import org.jivesoftware.xiff.data.IExtension;
	import org.jivesoftware.xiff.data.ISerializable;
		
	/**
	 * Implements http://jivesoftware.com/xmlns/log namespace. 
	 */
	 
	public class LoggerExtension extends Extension implements IExtension, ISerializable
	{
		public static var NS:String = "http://www.jivesoftware.com/protocol/log";
		public static var ELEMENT:String = "log";
		
		public var duration:String;
		public var numA:String;
		public var numB:String;
		public var datetime:String;
		public var type:String;
		
		
		public function LoggerExtension(duration:String, numA:String, numB:String, datetime:String, type:String)
		{
			this.duration = duration;
			this.numA = numA;
			this.numB = numB;
			this.datetime = datetime;
			this.type = type;
			
			super(null);
		}
			
		public function getNS():String
		{
			return LoggerExtension.NS;
		}
	
		public function getElementName():String
		{
			return LoggerExtension.ELEMENT;
		}
			
		public function serialize( parentNode:XMLNode ):Boolean		
		{       
			var durationNode:XMLNode = new XMLNode(1, 'duration');
			durationNode.appendChild(new XMLNode(3, this.duration));

			var numBNode:XMLNode = new XMLNode(1, 'numB');
			numBNode.appendChild(new XMLNode(3, this.numB));
			
			var numANode:XMLNode = new XMLNode(1, 'numA');
			numANode.appendChild(new XMLNode(3, this.numA));

			var datetimeNode:XMLNode = new XMLNode(1, 'datetime');
			datetimeNode.appendChild(new XMLNode(3, this.datetime));

			var typeNode:XMLNode = new XMLNode(1, 'type');
			typeNode.appendChild(new XMLNode(3, this.type));
			
			var xmlParentNode:XMLNode = new XMLNode(1, ELEMENT);			
			xmlParentNode.attributes.xmlns = NS;
			
			var xmlNode:XMLNode = new XMLNode(1, "callLog");			
			xmlNode.attributes.xmlns = NS;
			
			xmlNode.appendChild(durationNode);					
			xmlNode.appendChild(numBNode);	
			xmlNode.appendChild(numANode);								
			xmlNode.appendChild(datetimeNode);					
			xmlNode.appendChild(typeNode);					

			xmlParentNode.appendChild(xmlNode);			
			parentNode.appendChild(xmlParentNode);			
			return true;
		}
	
		public function deserialize( node:XMLNode ):Boolean
		{
			return true;
	
		}
				
	}
}