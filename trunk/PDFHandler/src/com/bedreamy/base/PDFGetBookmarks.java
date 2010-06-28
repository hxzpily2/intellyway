package com.bedreamy.base;

import java.io.File;
import java.io.IOException;
import java.security.NoSuchAlgorithmException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.TreeSet;
import java.util.Vector;

import org.apache.pdfbox.exceptions.InvalidPasswordException;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.interactive.documentnavigation.outline.PDDocumentOutline;
import org.apache.pdfbox.pdmodel.interactive.documentnavigation.outline.PDOutlineItem;

import com.bedreamy.commun.SHA1Util;

public class PDFGetBookmarks {

	private static final String PASSWORD = "-password";
	private static final String DESTINATIONPATH = "-destination";

	public static void main(String[] args) throws IOException {
		String password = "";
		String destination = "";
		String pdfFile = null;
		for (int i = 0; i < args.length; i++) {
			if (args[i].equals(PASSWORD)) {
				i++;
				if (i >= args.length) {
					usage();
				}
				password = args[i];
			}else if(args[i].equals(DESTINATIONPATH)) {
				i++;
				if (i >= args.length) {
					usage();
				}
				destination = args[i];
			}else {
				if (pdfFile == null) {
					pdfFile = args[i];
				}
			}
		}
		if (pdfFile == null) {
			usage();
		} else {
			PDDocument document = null;
			try {
				document = PDDocument.load(pdfFile);
				if (document.isEncrypted()) {
					try {
						document.decrypt(password);
					} catch (InvalidPasswordException e) {
						if (args.length == 4)// they supplied the wrong password
						{
							System.err
									.println("Error: The supplied password is incorrect.");
							System.exit(2);
						} else {
							// they didn't supply a password and the default of
							// "" was wrong.
							System.err
									.println("Error: The document is encrypted.");
							usage();
						}
					}
				}
				ArrayList allpages = new ArrayList();
				
			    document.getDocumentCatalog().getPages().getAllKids(allpages);
				PDDocumentOutline root = document.getDocumentCatalog().getDocumentOutline();
				PDOutlineItem item = root.getFirstChild();
				String jsonSignet = "";
				jsonSignet+= "{ identifier: 'id',\n";
				jsonSignet+= " label: 'name',\n";
				jsonSignet+= " items: [\n";
				while (item != null) {
					//System.out.println("Item:" + item.getTitle());
					PDOutlineItem child = item.getFirstChild();
					/*while (child != null) {
						//System.out.println("    Child:" + child.getTitle());
						//System.out.println();						
					    int pageNumber = allpages.indexOf(child.findDestinationPage(document))+1;
					    //System.out.println(pageNumber);
					    //jsonSignet += PDFGetBookmarks.getJsonTreeForChild(child,allpages);
					    if(child.getNextSibling()==null)
						    ;
					    else ;
					    	
						child = child.getNextSibling();
						
					}*/
					jsonSignet += getJsonTreeForItem(item,allpages,document);
					item = item.getNextSibling();
				}
				jsonSignet+= " ]} ";
				System.out.println(jsonSignet);
			} catch (Exception e) {
				System.err.println(e);
			} finally {
				if (document != null) {
					document.close();
				}
			}
		}
	}
	private static String getJsonTreeForItem(PDOutlineItem child,ArrayList allPages,PDDocument document) throws Exception{
		if(child!=null){
			if(child.getNextSibling()!=null)
				return " {id : '"+SHA1Util.SHA1(child.getTitle())+"',\n" +
			       " type:'chapter',"+
			       " page : '"+(allPages.indexOf(child.findDestinationPage(document))+1)+"',\n" +
			       " name: '"+child.getTitle()+"',\n"	+			       
			       getJsonTreeForChild(child, allPages, document)+
			       "},\n";
			else
				return " {id : '"+SHA1Util.SHA1(child.getTitle())+"',\n" +
			       " type:'chapter',"+
			       " page : '"+(allPages.indexOf(child.findDestinationPage(document))+1)+"',\n" +
			       " name: '"+child.getTitle()+"',\n"	+			       
			       getJsonTreeForChild(child, allPages, document)+
			       "}\n";
		}else
			return "";
	}
	
	private static Vector<String> items = new Vector<String>();
	
	private static String getJsonTreeForChild(PDOutlineItem child,ArrayList allPages,PDDocument document) throws IOException, Exception{
		if(child!=null){
			PDOutlineItem item = child.getFirstChild();
			String reference = "";
			String itemJson = "";
			while (item != null) {
				//System.out.println(item.getTitle());
				reference = "{_reference : '"+SHA1Util.SHA1(item.getTitle())+"'}";
				if(item.getNextSibling()!=null)
					reference+=",";
				items.add("{id : '"+SHA1Util.SHA1(child.getTitle())+"',\n" +
				       " type:'chapter',"+
				       " page : '"+(allPages.indexOf(child.findDestinationPage(document))+1)+"',\n" +
				       " name: '"+child.getTitle()+"',\n"	+			       
				       getJsonTreeForChild(item, allPages, document));
				item = item.getNextSibling();
			}
			if(reference!="")
				return " children: ["+reference+"]";
			else
				return " children: []";
				   
		}else
			return " children: []";
	}
	
	private static void usage() {
		System.err
				.println("Usage: java com.bedreamy.base.PDFGetBookmarks [OPTIONS] <PDF file>\n"
						+ "  -password  <password>          Password to decrypt document\n"
						+ "  <PDF file>                     The PDF document to use\n");
		System.exit(1);
	}
}
