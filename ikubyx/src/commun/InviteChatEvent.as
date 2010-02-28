package commun
{
	import flash.events.Event;

	public class InviteChatEvent extends Event
	{
		public var username : String;
		public function InviteChatEvent(type:String,username : String)
		{
			this.username = username;
			super(type);
		}
		
	}
}