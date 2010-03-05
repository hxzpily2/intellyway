package model.vo
{
	import weborb.messaging.WeborbConsumer;
	
	[RemoteClass(alias="amji.vo.TypeVO")]     
    [Bindable]
	public class TypeVO
	{
		
		public var idtype : Number;
		public var libelle : String;
		public var description : String;
		public var consumer : WeborbConsumer;
	
		public function TypeVO()
		{
		}

	}
}