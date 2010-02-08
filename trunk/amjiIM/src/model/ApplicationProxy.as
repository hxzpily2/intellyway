package model
{
	import model.vo.LoginVO;
	
	import org.puremvc.as3.interfaces.IProxy;
	import org.puremvc.as3.patterns.proxy.Proxy;
	
	public class ApplicationProxy  extends Proxy implements IProxy 
	{
		public static const NAME:String = "ApplicationProxy";
		public var userConnected : LoginVO = null;
		public function ApplicationProxy(proxyName:String=null, data:Object=null)
		{
			super(NAME, data );
		}

	}
}