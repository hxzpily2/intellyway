package commun
{
	import flash.events.Event;

	public class AcceptContact extends Event
	{
		public var id : Number;
		public function AcceptContact(type:String,id : Number)
		{
			this.id=id;
			super(type);			
		}
		
	}
}