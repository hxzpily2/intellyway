package commun
{
	import flash.events.Event;
	
	import model.chat.IkubyxMessage;

	public class IkubyxSendMsgEvent extends Event
	{
		public var msg : IkubyxMessage;
		public static var MESSAGEEVENT : String = "MESSAGEEVENT";
		
		public function IkubyxSendMsgEvent(type:String,message : IkubyxMessage, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			this.msg = message;
		}
		
	}
}