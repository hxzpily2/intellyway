package com.bedreamy.components.feedbackpopup
{
	import flash.events.Event;
	
	import mx.core.UIComponent;
	import mx.effects.Fade;
	import mx.managers.PopUpManager;
	
	public class FeedbackPopup
	{
		private static var popup : FeedbackVbox = new FeedbackVbox(); 
		private static var _app : UIComponent;
		private static var dissolve : Fade = new Fade();
		
		public var timeout:String;
		
		public function FeedbackPopup()
		{
			//par defaut la durée
			if(timeout==null){
				timeout = "5000";
			}
		}
				
		public static function setApp(component : UIComponent):void{
			_app = component;
		}
		
		public static function show(text : String , title : String = null , type : String = null):void{
			dissolve.alphaFrom = 0;
            dissolve.alphaTo = 1;
            dissolve.duration = 500;
			
			//popup.addEventListener(FeedbackVbox.OKEVENT,okButton);
			
			//popup.text = text;
			//popup.width = 330;
			//////popup.height = 180;
			/*if(title)
				popup.title = title;
			if(type){
				popup.type = type;
				popup.init();
			}*/
			PopUpManager.addPopUp(popup, _app, true);
            PopUpManager.centerPopUp(popup);
            
            dissolve.target=popup;
            dissolve.play(); 
            
		}
		
		private static function okButton(event : Event):void{
			PopUpManager.removePopUp(popup);
		}	

	}
}