package com.bedreamy.base;

import java.awt.Color;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Vector;

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
import com.bedreamy.model.PDFHighlightingItem;



public class PDFHighlighting {

	private static final String PAGE = "-page";
	private static final String ROLLBACK = "-r";
	private static final String WORDS = "-word";

	public static final void main(String[] args) throws IOException,
			COSVisitorException {
		String page = "";
		boolean rollback = false;
		String pdfFile = null;
		String word = null;
		
		for (int i = 0; i < args.length; i++) {
			if (args[i].equals(PAGE)) {
				i++;
				if (i >= args.length) {
					usage();
				}
				page = args[i];
			}else if (args[i].equals(ROLLBACK)) {
				rollback = true;
			}else if (args[i].equals(WORDS)) {
				i++;
				if (i >= args.length) {
					usage();
				}
				word = args[i];
			}else {
				if (pdfFile == null) {
					pdfFile = args[i];
				}
			}
		}
		
		PDDocument doc = PDDocument.load(new File("test.pdf"));
		ArrayList allPages = (ArrayList) doc.getDocumentCatalog().getAllPages();
		PrintTextLocations printer = new PrintTextLocations();
		int i;
		Vector<PDFHighlightingItem> result = new Vector<PDFHighlightingItem>();
		for (i = new Integer(page).intValue()-1; i < allPages.size(); i++) { 
			PDPage pagePD = (PDPage)allPages.get(i);
			printer.setPage(i);
			printer.processStream(pagePD, pagePD.findResources(),pagePD.getContents().getStream());
			Vector<PDFHighlightingItem> vect = printer.getMap().get(new Integer(i));			
			if(vect!=null){
				for(int j=0;j<vect.size();j++){
					PDFHighlightingItem temp = (PDFHighlightingItem)vect.get(j);
					//System.out.println(temp.getItem());
					
					int pos = temp.getItem().indexOf(word);
					
					if(pos>=0){						
						//calculer la position du text
						PDFHighlightingItem item = new PDFHighlightingItem();
						float widthcar = temp.getWidth()/temp.getItem().length();
						item.setWidth(widthcar*word.length());
						item.setFontsize(temp.getFontsize());
						item.setHeight(temp.getHeight());
						item.setItem(word);
						item.setPage(i);
						item.setWidthofspace(temp.getWidthofspace());
						item.setX(temp.getX()+(pos*widthcar));
						item.setXscale(temp.getXscale()+(pos*widthcar));
						item.setY(temp.getY());
						item.setYscale(temp.getYscale());												
						result.add(item);
						//fin calcul
					}			
				}
			}
			
			if(result.size()>0)
				break;			
		}	
		
		/*if(result.size()>0){
			PDPage finalpage = (PDPage) allPages.get(i);
			PDPageContentStream contentStream = new PDPageContentStream(doc,
					finalpage, true, false);
			
			for(int k=0;k<result.size();k++){
				PDFHighlightingItem temp = (PDFHighlightingItem)result.get(k);
				contentStream.setNonStrokingColor(Color.YELLOW);
				int x0 = (int) Math.round(temp.getX());
				int y0 = Math.round((float) ((finalpage).findMediaBox().getHeight() - temp.getY()));

				contentStream.fillRect(x0 , y0 , x0- (finalpage).findMediaBox().getWidth()+Math.round(temp.getWidth()) + 2, y0 + temp.getHeight());
				
				System.out.println(x0+","+y0);
				break;
			}
			contentStream.close();
		}
		
		doc.save("test2.pdf");
		doc.close();*/
		
		PDPageContentStream contentStream = new PDPageContentStream(doc,(PDPage)allPages.get(11),true,false);		
		
		
		contentStream.setNonStrokingColor( Color.YELLOW );
		int x0 = (int)((PDPage)allPages.get(11)).findMediaBox().getLowerLeftX()+(int) Math.round(456.81573)-(int)((PDPage)allPages.get(11)).findMediaBox().getWidth();
		int y0 = 0-(int) Math.round(678.8693)+(int)((PDPage)allPages.get(11)).findMediaBox().getHeight();
		System.out.println(x0+","+y0);
		contentStream.fillRect( x0-2, y0-2, 10, 6+4 );
		
		/*PDFont font = PDType1Font.HELVETICA;		
		
		contentStream.setNonStrokingColor( Color.BLACK );
		contentStream.beginText();		
		contentStream.setFont( font, (float) 8.8 );
		contentStream.moveTextPositionByAmount( (float) 307.55, (float) (((PDPage)allPages.get(458)).findMediaBox().getHeight()-519.1374) );
		contentStream.drawString( "Master the most important areas of Java" );
		contentStream.endText();*/

		contentStream.close();
		
		

		doc.save("test2.pdf");
		doc.close();	
	}
	
	private static void usage() {
		System.err
				.println("Usage: java com.bedreamy.base.PDFGetBookmarks [OPTIONS] <PDF file>\n"
						+ "  -password  <password>           Password to decrypt document\n"
						+ "  -destination  <destination>     Destination du fichier bookmark en JSON\n"
						+ "  -destinationInfo  <destination> Destination du fichier infos en JSON\n"
						+ "  <PDF file>                      The PDF document to use\n");
		System.exit(1);
	}

	/*
	 * public static void main( String[] args ) throws IOException,
	 * COSVisitorException{ //PDDocument doc = PDDocument.load(new
	 * File("test.pdf")); /PrintTextLocations printer = new
	 * PrintTextLocations(); ArrayList allPages = (ArrayList)
	 * doc.getDocumentCatalog().getAllPages();
	 * //System.out.println(allPages.size());
	 * 
	 * for (int i = 0; i < allPages.size(); i++) { PDPage page = (PDPage)
	 * allPages.get(i); printer.setPage(i);
	 * //System.out.println("Processing page: " + i);
	 * printer.processStream(page, page.findResources(),
	 * page.getContents().getStream()); }
	 * System.out.println(printer.getMap().size()); PDPageContentStream
	 * contentStream = new
	 * PDPageContentStream(doc,(PDPage)allPages.get(0),true,false);
	 * contentStream.setNonStrokingColor( Color.CYAN ); contentStream.fillRect(
	 * 0,0, ((PDPage)allPages.get(0)).findMediaBox().getWidth(),
	 * ((PDPage)allPages.get(0)).findMediaBox().getHeight() );
	 * contentStream.setNonStrokingColor( Color.LIGHT_GRAY );
	 * contentStream.fillRect( 100, 700, 100, 12 );
	 * 
	 * PDFont font = PDType1Font.HELVETICA_BOLD;
	 * 
	 * contentStream.setNonStrokingColor( Color.BLACK );
	 * contentStream.beginText(); contentStream.setFont( font, 12 );
	 * contentStream.moveTextPositionByAmount( 100, 700 );
	 * contentStream.drawString( "Hello World" ); contentStream.endText();
	 * 
	 * contentStream.close();
	 * 
	 * 
	 * 
	 * doc.save("test2.pdf"); doc.close(); org.apache.lucene.document.Document
	 * doc = LucenePDFDocument.getDocument(new File("test.pdf")); /Highlighter
	 * highlighter = new Highlighter(new QueryScorer(query)); TokenStream
	 * tokenStream = new SimpleAnalyzer().tokenStream(FIELD_NAME, new
	 * FileReader(f));
	 * 
	 * doc.add(Field.Text("contents", new FileReader(f)));
	 * 
	 * 
	 * 
	 * 
	 * }
	 */

}
