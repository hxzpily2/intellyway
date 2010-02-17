package commun.components
{
	import flash.display.Bitmap;
    import flash.display.BitmapData;
    import flash.display.Graphics;
    import flash.display.Loader;
    import flash.events.Event;
    import flash.events.IOErrorEvent;
    import flash.geom.Matrix;
    import flash.net.URLRequest;
    
    import mx.controls.Image;
    import mx.core.BitmapAsset;
    import mx.graphics.RectangularDropShadow;
    import mx.skins.RectangularBorder;
    import mx.core.Application;
    import mx.core.UIComponent;

    public class RepeatedBackground extends RectangularBorder {  

        private var tile:BitmapData;
        
        private var imgCls:Class;
        
        override protected function updateDisplayList(unscaledWidth:Number, unscaledHeight:Number):void {
            super.updateDisplayList(unscaledWidth, unscaledHeight);
            
            // Use UIComponent to handle any container
            
            // Check if parent is valid 
            // In some Application initializaton states this might be false, I was getting an error
            if( this.parent != null ) {
                // The backgroundImage on the parent will become "" so we need to keep the class around
                // for every object updateDisplayList
                if( imgCls == null ) {
                    var backgroundImage:Object = UIComponent( this.parent ).getStyle( "backgroundImage" );
                    if( backgroundImage != null && backgroundImage != "" ) {
                        imgCls = Class( backgroundImage );
                        (this.parent as UIComponent).setStyle( "backgroundImage", "" );
                        (this.parent as UIComponent).setStyle( "backgroundAlpha", "0.7" );
                    }
                }
                // Do the actually bitmap filling here
                if( imgCls != null ) {
                    try {
                        // imgCls could be a symbol in a SWF and the class will not work
                        var background:BitmapAsset = BitmapAsset(new imgCls());
                        background.alpha = 0.7;
                        tile = background.bitmapData;
                        
                        var transform: Matrix = new Matrix();
    
                        graphics.clear();
                        graphics.beginBitmapFill(tile, transform, true);
                        graphics.drawRect(0, 0, unscaledWidth, unscaledHeight);
                        
                    } catch( e:TypeError ) {
                        // Throw an custom error if imgCls is not a valid type
                        throw new Error( "backgroundImage value is not a valid image class" );
                    } finally {
                        ;// Catch all just ignore
                    }
                }
            }
        }
    } 
}