package org.igniterealtime.xiff.data.pubsub {

	import flash.xml.XMLNode;	
	import org.jivesoftware.xiff.data.IExtension;
	import org.jivesoftware.xiff.data.ISerializable;
	import org.jivesoftware.xiff.data.Extension;	

	public class PEPStorage extends Extension implements IExtension, ISerializable
	{
		private var pepNode:XMLNode;
		public static var NS:String = "jabber:iq:private";
		public static var ELEMENT:String = "query";
		
		
		public function PEPStorage(pepNode:XMLNode):void {
			super(null);
			this.pepNode = pepNode;
		}
		
		public function getNS():String
		{
			return PEPStorage.NS;
		}
	
		public function getElementName():String
		{
			return PEPStorage.ELEMENT;
		}
		
		
		public function serialize(parentNode:XMLNode):Boolean
		{
			var query:XMLNode = new XMLNode(1, "query");
			query.attributes.xmlns = "jabber:iq:private";			
			query.appendChild(pepNode);
			parentNode.appendChild(query);
			return true;			
		}
		
		
		public function deserialize(node:XMLNode):Boolean
		{
			return true;
		}
		
	}
}
