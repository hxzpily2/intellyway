package com.bedreamy.base;



import java.awt.Color;
import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import org.apache.lucene.document.Document;
import org.apache.pdfbox.examples.util.PrintTextLocations;
import org.apache.pdfbox.exceptions.COSVisitorException;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.PDPage;
import org.apache.pdfbox.pdmodel.common.PDRectangle;
import org.apache.pdfbox.pdmodel.edit.PDPageContentStream;
import org.apache.pdfbox.pdmodel.font.PDFont;
import org.apache.pdfbox.pdmodel.font.PDType1Font;
import org.apache.pdfbox.pdmodel.graphics.color.PDGamma;
import org.apache.pdfbox.pdmodel.interactive.annotation.PDAnnotationTextMarkup;
import org.apache.pdfbox.searchengine.lucene.LucenePDFDocument;



public class PDFHighlighting {
	
	private static final String LASTPAGE = "-lastPage";    
	private static final String OCCURENCE = "-occurence";
    
	public static void main( String[] args ) throws IOException, COSVisitorException{		
		 PDDocument doc = PDDocument.load(new File("oracle-10g-11g-data-and-database-management-utilities.9781847196286.47538.pdf"));
		 PrintTextLocations printer = new PrintTextLocations();
		 ArrayList allPages = (ArrayList) doc.getDocumentCatalog().getAllPages();
		 System.out.println(allPages.size());

		/*for (int i = 0; i < allPages.size(); i++) {
			PDPage page = (PDPage) allPages.get(i);
			System.out.println("Processing page: " + i);
			printer.processStream(page, page.findResources(), page.getContents().getStream());						
		}*/
		
		PDPageContentStream contentStream = new PDPageContentStream(doc,(PDPage)allPages.get(0),true,false);		
		contentStream.setNonStrokingColor( Color.CYAN );
		//contentStream.fillRect( 0,0, ((PDPage)allPages.get(0)).findMediaBox().getWidth(), ((PDPage)allPages.get(0)).findMediaBox().getHeight() );
		contentStream.setNonStrokingColor( Color.LIGHT_GRAY );
		contentStream.fillRect( 100, 700, 100, 12 );
		
		PDFont font = PDType1Font.HELVETICA_BOLD;
		
		contentStream.setNonStrokingColor( Color.BLACK );
		contentStream.beginText();		
		contentStream.setFont( font, 12 );
		contentStream.moveTextPositionByAmount( 100, 700 );
		contentStream.drawString( "Hello World" );
		contentStream.endText();

		contentStream.close();
		
		/*List annotations = ((PDPage)allPages.get(0)).getAnnotations();
		
		PDGamma colourBlue = new PDGamma();
		colourBlue.setB(1);

		PDAnnotationTextMarkup txtMark = new PDAnnotationTextMarkup(PDAnnotationTextMarkup.SUB_TYPE_HIGHLIGHT);
		txtMark.setColour(colourBlue);
		txtMark.setConstantOpacity((float)0.1);
		

		// Set the rectangle containing the markup

		float textWidth = 10;
		float inch = 72;
		float pw = ((PDPage)allPages.get(0)).getMediaBox().getUpperRightX();
		float ph = ((PDPage)allPages.get(0)).getMediaBox().getUpperRightY();

		
		PDRectangle position = new PDRectangle();
		position.setLowerLeftX(inch);
		position.setLowerLeftY(ph - inch - 18);
		position.setUpperRightX(72 + textWidth);
		position.setUpperRightY(ph - inch);
		txtMark.setRectangle(position);

		// work out the points forming the four corners of the annotations
		// set out in anti clockwise form (Completely wraps the text)
		// OK, the below doesn't match that description.
		// It's what acrobat 7 does and displays properly!
		float[] quads = new float[8];

		quads[0] = position.getLowerLeftX(); // x1
		quads[1] = position.getUpperRightY() - 5; // y1
		quads[2] = position.getUpperRightX(); // x2
		quads[3] = quads[1]; // y2
		quads[4] = quads[0]; // x3
		quads[5] = position.getLowerLeftY() - 5; // y3
		quads[6] = quads[2]; // x4
		quads[7] = quads[5]; // y5

		txtMark.setQuadPoints(quads);
		

		annotations.add(txtMark);*/	

		doc.save("test.pdf");
		doc.close();
		
	}
	
}
