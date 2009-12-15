package com.bedreamy.components.preloader
{
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.ProgressEvent;
	
	import mx.events.FlexEvent;
	import mx.preloaders.DownloadProgressBar;
	
	public class CustomPreloader extends DownloadProgressBar
	{
		public var wcs:MovieClip;
		public var preloaderClass : Class;
		
		
		[Embed(source="assets/flash/templatePreloader.swf", symbol="CustomPreloader")]
		private var DefaultPreloaderClass : Class;
		
		public function CustomPreloader()
		{
			if(this.preloaderClass!=null)
				wcs = new preloaderClass();	
			else
				wcs = new DefaultPreloaderClass();			
			
			super();
						
			addChild(wcs);
			wcs.gotoAndStop(0);
		}
		
		public override function set preloader(preloader:Sprite):void 
        {                   
            preloader.addEventListener( ProgressEvent.PROGRESS , 	onSWFDownloadProgress );    
            preloader.addEventListener( Event.COMPLETE , 			onSWFDownloadComplete );
            preloader.addEventListener( FlexEvent.INIT_PROGRESS , 	onFlexInitProgress );
            preloader.addEventListener( FlexEvent.INIT_COMPLETE , 	onFlexInitComplete );
            
            centerPreloader();
        }
		
		private function centerPreloader():void
        {
            x = (stageWidth / 2) - (wcs.width / 2);
            y = (stageHeight / 2) - (wcs.height / 2);
        }
        
        private function onSWFDownloadProgress( event:ProgressEvent ):void
        {
        	var t:Number = event.bytesTotal;
        	var l:Number = event.bytesLoaded;
        	var p:Number = Math.round( (l / t) * 100);
        	wcs.preloader.gotoAndStop(p);
        	wcs.preloader.amount_txt.text = String(p) + "%";
        }
        
        /**
         * When the download of frame 2
         * is complete, this event is called.  
         * This is called before the initializing is done.
         * @param event
         * 
         */        
        private function onSWFDownloadComplete( event:Event ):void
        {
       		wcs.preloader.gotoAndStop(100);
        	wcs.preloader.amount_txt.text = "100%";
        }
        
        /**
         * When Flex starts initilizating your application.
         * @param event
         * 
         */        
        private function onFlexInitProgress( event:FlexEvent ):void
        {
        	wcs.preloader.gotoAndStop(100);
        	wcs.preloader.amount_txt.text = "Initializing...";
        }
        
        /**
         * When Flex is done initializing, and ready to run your app,
         * this function is called.
         * 
         * You're supposed to dispatch a complete event when you are done.
         * I chose not to do this immediately, and instead fade out the 
         * preloader in the MovieClip.  As soon as that is done,
         * I then dispatch the event.  This gives time for the preloader
         * to finish it's animation.
         * @param event
         * 
         */        
        private function onFlexInitComplete( event:FlexEvent ):void 
        {
        	//frame number where the animation is stopped
        	wcs.addFrameScript(7, onDoneAnimating);
        	wcs.gotoAndPlay("effect");
        }
        
        /**
         * If the Flash MovieClip is done playing it's animation,
         * I stop it and dispatch my event letting Flex know I'm done.
         * @param event
         * 
         */        
        private function onDoneAnimating():void
        {
        	wcs.stop();
        	dispatchEvent( new Event( Event.COMPLETE ) );
        }


	}
}