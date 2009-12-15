package com.bedreamy.components.voile
{
	import mx.controls.ProgressBar;
	import mx.controls.ProgressBarMode;
	import mx.core.UIComponent;
	import mx.effects.Fade;
	import mx.events.CloseEvent;
	import mx.events.FlexEvent;
	import mx.managers.PopUpManager;
	
	
	
	public class Voile
	{
		private static var _progBar:ProgressBar;
		private static var fade:Fade;

		public function Voile()
		{
			
		}
		
		public static function hide(component : UIComponent , label : String = ""):void{
			
			if(_progBar == null)
                        {
                                _progBar = new ProgressBar();
                                _progBar.width = 200;
                                _progBar.height = 10;
                                _progBar.indeterminate = true;
                                _progBar.labelPlacement = 'center';
                                _progBar.setStyle("removedEffect", fade);
                                _progBar.setStyle("addedEffect", fade);
                                _progBar.setStyle("color", 0xFFFFFF);
                                _progBar.setStyle("borderColor", 0xffcc00);
                                _progBar.setStyle("barColor", 0xf4b60f);
                                _progBar.label = label;
                                _progBar.mode = ProgressBarMode.MANUAL;
                        }
                        PopUpManager.addPopUp(_progBar,component,true);
                        PopUpManager.centerPopUp(_progBar);
                         _progBar.setProgress(0, 0);			
		}

		private static function closeHandler(event:CloseEvent):void{
			
		}

		private static function init(event : FlexEvent):void{
			
		}
		
		public static function show():void{
			PopUpManager.removePopUp(_progBar);
		}

	}
}