package com.bedreamy.facade
{
	import mx.core.UIComponent;
	
	public class MainFacade
	{
		public var mainapplication : UIComponent;
		public static var instance : MainFacade;
		public function MainFacade()
		{
		}
		
		public static function getInstance() : MainFacade {  
  
            if ( instance == null ) instance = new MainFacade( );  
  
            return instance as MainFacade;  
  
        }
        
        public function setMainApplication(app : UIComponent):void{
        	this.mainapplication = app;
        }
        
        public function getMailApplication():UIComponent{
        	return mainapplication;
        }

	}
}