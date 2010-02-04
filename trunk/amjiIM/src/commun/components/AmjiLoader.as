package commun.components
{
	import mx.controls.SWFLoader;
	import mx.core.UIComponent;
	import mx.effects.Fade;
	import mx.managers.PopUpManager;
	
	public class AmjiLoader
	{
		private static var fade:Fade;
		private static var _progBar:SWFLoader;
		[Embed(source="AmjiTheme.swf",symbol="PreloaderSkin")]
		private static var preloader:Class;
		
		public function AmjiLoader()
		{
			
		}
		
		public static function hide(component : UIComponent , label : String = ""):void{
			
			if(_progBar == null)
                        {
                                _progBar = new SWFLoader();                                
                                _progBar.source = preloader;
                                _progBar.setStyle("removedEffect", fade);
                                _progBar.setStyle("addedEffect", fade);
                                _progBar.setStyle("color", 0xFFFFFF);
                                _progBar.setStyle("borderColor", 0xffcc00);
                                _progBar.setStyle("barColor", 0xf4b60f);
                                                                
                                
                        }
                        PopUpManager.addPopUp(_progBar,component,true);
                        PopUpManager.centerPopUp(_progBar);
                         			
		}
		
		public static function show():void{
			PopUpManager.removePopUp(_progBar);
		}

	}
}