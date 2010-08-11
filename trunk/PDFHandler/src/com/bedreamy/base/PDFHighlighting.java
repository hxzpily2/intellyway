package com.bedreamy.base;



import java.awt.Color;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import javax.management.Query;
import javax.swing.text.Highlighter;

import org.apache.lucene.analysis.Analyzer;
import org.apache.lucene.analysis.standard.StandardAnalyzer;
import org.apache.lucene.document.Document;
import org.apache.lucene.index.IndexWriter;
import org.apache.lucene.index.Term;
import org.apache.lucene.search.IndexSearcher;
import org.apache.lucene.search.TermQuery;
import org.apache.lucene.store.Directory;
import org.apache.lucene.store.RAMDirectory;

import org.apache.pdfbox.cos.COSDocument;
import org.apache.pdfbox.exceptions.COSVisitorException;
import org.apache.pdfbox.pdfparser.PDFParser;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.PDPage;
import org.apache.pdfbox.pdmodel.common.PDRectangle;
import org.apache.pdfbox.pdmodel.edit.PDPageContentStream;
import org.apache.pdfbox.pdmodel.font.PDFont;
import org.apache.pdfbox.pdmodel.font.PDTrueTypeFont;
import org.apache.pdfbox.pdmodel.font.PDType1Font;
import org.apache.pdfbox.pdmodel.graphics.color.PDGamma;
import org.apache.pdfbox.pdmodel.interactive.annotation.PDAnnotationTextMarkup;
import org.apache.pdfbox.pdmodel.interactive.documentnavigation.outline.PDDocumentOutline;
import org.apache.pdfbox.searchengine.lucene.LucenePDFDocument;
import org.apache.pdfbox.util.PDFTextStripper;


import com.bedreamy.commun.PrintTextLocations;



public class PDFHighlighting {
	
	private static final String LASTPAGE = "-lastPage";    
	private static final String OCCURENCE = "-occurence";
    
	/*public static void main( String[] args ) throws IOException, COSVisitorException{		
		 //PDDocument doc = PDDocument.load(new File("test.pdf"));
		 /*PrintTextLocations printer = new PrintTextLocations();
		 ArrayList allPages = (ArrayList) doc.getDocumentCatalog().getAllPages();
		 //System.out.println(allPages.size());

		for (int i = 0; i < allPages.size(); i++) {
			PDPage page = (PDPage) allPages.get(i);
			printer.setPage(i);
			//System.out.println("Processing page: " + i);
			printer.processStream(page, page.findResources(), page.getContents().getStream());						
		}
		System.out.println(printer.getMap().size());
		PDPageContentStream contentStream = new PDPageContentStream(doc,(PDPage)allPages.get(0),true,false);		
		contentStream.setNonStrokingColor( Color.CYAN );
		contentStream.fillRect( 0,0, ((PDPage)allPages.get(0)).findMediaBox().getWidth(), ((PDPage)allPages.get(0)).findMediaBox().getHeight() );
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
		
		

		doc.save("test2.pdf");
		doc.close();
		 org.apache.lucene.document.Document doc =
			 LucenePDFDocument.getDocument(new File("test.pdf"));
		 /*Highlighter highlighter = new Highlighter(new
				 QueryScorer(query));
				             TokenStream tokenStream = new
				 SimpleAnalyzer().tokenStream(FIELD_NAME,
				                     new FileReader(f));

				             doc.add(Field.Text("contents", new FileReader(f)));
		 


		
	}*/
	
	public static final void main(String[] args) throws IOException, COSVisitorException
    {
		/*Document doc = LucenePDFDocument.getDocument(new File("test.pdf"));
		
		
		/*System.out.println(doc.getField("Keywords"));*/
		
		PDDocument doc = PDDocument.load(new File("test.pdf"));
		ArrayList allPages = (ArrayList) doc.getDocumentCatalog().getAllPages();
		/* PrintTextLocations printer = new PrintTextLocations();
		 
		 //System.out.println(allPages.size());

		for (int i = 0; i < allPages.size(); i++) {
			PDPage page = (PDPage) allPages.get(i);
			printer.setPage(i);
			//System.out.println("Processing page: " + i);
			printer.processStream(page, page.findResources(), page.getContents().getStream());						
		}
		System.out.println(printer.getMap().size());*/
		
		PDPageContentStream contentStream = new PDPageContentStream(doc,(PDPage)allPages.get(458),true,false);		
		
		
		contentStream.setNonStrokingColor( Color.YELLOW );
		int x0 = (int) Math.round(307.55);
		int y0 = Math.round((float) (((PDPage)allPages.get(458)).findMediaBox().getHeight()-519.1374));
		
		contentStream.fillRect( x0-2, y0-2, Math.round(158.94897)+2, 6+4 );
		
		PDFont font = PDType1Font.HELVETICA;		
		
		contentStream.setNonStrokingColor( Color.BLACK );
		contentStream.beginText();		
		contentStream.setFont( font, (float) 8.8 );
		contentStream.moveTextPositionByAmount( (float) 307.55, (float) (((PDPage)allPages.get(458)).findMediaBox().getHeight()-519.1374) );
		contentStream.drawString( "Master the most important areas of Java" );
		contentStream.endText();

		contentStream.close();
		
		

		doc.save("test2.pdf");
		doc.close();
		
		  /* FileInputStream fi = new FileInputStream(new File("test.pdf"));  
		    
		   PDFParser parser = new PDFParser(fi);  
		   parser.parse();  
		   COSDocument cd = parser.getDocument();  
		   PDFTextStripper stripper = new PDFTextStripper();  
		   String text = stripper.getText(new PDDocument(cd));
		   System.out.println(cd.toString()); */
		


		   
    }
	
}
