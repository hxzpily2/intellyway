package com.bedreamy.base;

import java.awt.List;
import java.io.File;
import java.io.IOException;
import java.util.ArrayList;

import org.apache.lucene.document.Document;
import org.apache.pdfbox.examples.util.PrintTextLocations;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.PDPage;
import org.apache.pdfbox.searchengine.lucene.LucenePDFDocument;



public class PDFHighlighting {
	
	private static final String LASTPAGE = "-lastPage";    
	private static final String OCCURENCE = "-occurence";
    
	public static void main( String[] args ) throws IOException{
		//Document luceneDocument = LucenePDFDocument.getDocument(new File("test.pdf"));
		 PDDocument doc = PDDocument.load(new File("test.pdf"));
		 PrintTextLocations printer = new PrintTextLocations();
		 ArrayList allPages = (ArrayList) doc.getDocumentCatalog().getAllPages();
		 System.out.println(allPages.size());

		for (int i = 0; i < allPages.size(); i++) {
			PDPage page = (PDPage) allPages.get(i);
			System.out.println("Processing page: " + i);
			printer.processStream(page, page.findResources(), page.getContents().getStream());
			
		}
		
		 doc.close();
			 


	}
	
}
