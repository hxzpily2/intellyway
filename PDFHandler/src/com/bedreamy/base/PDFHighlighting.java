package com.bedreamy.base;

import java.awt.List;
import java.io.File;
import java.io.IOException;
import java.util.ArrayList;

import org.apache.lucene.document.Document;
import org.apache.pdfbox.examples.util.PrintTextLocations;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.searchengine.lucene.LucenePDFDocument;



public class PDFHighlighting {
	
	private static final String LASTPAGE = "-lastPage";    
    
	public static void main( String[] args ) throws IOException{
		//Document luceneDocument = LucenePDFDocument.getDocument(new File("test.pdf"));
		 PDDocument doc = PDDocument.load(new File("test.pdf"));
		 PrintTextLocations printer = new PrintTextLocations();
		 ArrayList allPages = (ArrayList) doc.getDocumentCatalog().getAllPages();
		 System.out.println(allPages.size());

		 

	}
	
}
