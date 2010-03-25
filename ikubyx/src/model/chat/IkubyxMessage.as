package model.chat
{
	import mx.collections.ArrayCollection;
	
	public class IkubyxMessage
	{
		public function IkubyxMessage()
		{
		}
		public var msg : XML;
		public var jidFrom : String;
		public var jidTo : String;
		public var priority : String;
		public var ismine : Boolean = false;
		public var elementFlow : ArrayCollection;
		public var datesend : Date;

	}
}