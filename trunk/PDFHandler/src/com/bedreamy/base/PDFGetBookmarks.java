package com.bedreamy.base;

import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.security.NoSuchAlgorithmException;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.TreeSet;
import java.util.Vector;

import org.apache.pdfbox.exceptions.InvalidPasswordException;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.interactive.documentnavigation.outline.PDDocumentOutline;
import org.apache.pdfbox.pdmodel.interactive.documentnavigation.outline.PDOutlineItem;
import org.json.simple.JSONValue;

import com.bedreamy.commun.HTMLEntities;
import com.bedreamy.commun.SHA1Util;
import com.bedreamy.model.BookmarkItem;

public class PDFGetBookmarks {

	private static final String PASSWORD = "-password";
	private static final String DESTINATIONPATH = "-destination";
	private static final String DESTINATIONINFOPATH = "-destinationInfo";
	
	private static Integer count=0;
	
	public static void main(String[] args) throws IOException {
		String password = "";
		String destination = null;
		String pdfFile = null;
		String destinationInfo = null;
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
			}else if(args[i].equals(DESTINATIONINFOPATH)) {
				i++;
				if (i >= args.length) {
					usage();
				}
				destinationInfo = args[i];
			}else {
				if (pdfFile == null) {
					pdfFile = args[i];
				}
			}
		}
		if (pdfFile == null) {
			usage();
		}else if(destination==null){
			usage();
		}else if(destinationInfo==null){
			usage();
		}else {
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
				
				String nbPages = new Integer(allpages.size()).toString();
				String titre = document.getDocumentInformation().getTitle();
				String auteur = document.getDocumentInformation().getAuthor();	
				SimpleDateFormat  simpleFormat = new SimpleDateFormat("dd/MM/yyyy");
				String dateCreation = simpleFormat.format( new Date(document.getDocumentInformation().getCreationDate().getTime().getTime()) );				
				String sujet = document.getDocumentInformation().getSubject();
				
				String info = "";
				
				info += "{ 'items': [";				           
				info += "{pages : '"+nbPages+"',titre : '"+titre+"',auteur : '"+auteur+"',date : '"+dateCreation+"',sujet : '"+sujet+"'}";
				info += "]}";
				
				FileWriter sortieInfo = new FileWriter(destinationInfo+".json");
				sortieInfo.write(info);
				sortieInfo.close();				
				
				sortieInfo = new FileWriter(destinationInfo+".xml");
				String xml = "<document>";
				xml+="<pages>"+nbPages+"</pages>";
				xml+="<titre>"+titre+"</titre>";
				xml+="<date>"+dateCreation+"</date>";
				xml+="<sujet>"+sujet+"</sujet>";
				xml+= "</document>";
				sortieInfo.write(xml);
				sortieInfo.close();
				
				while (item != null) {
					BookmarkItem bookItem = new BookmarkItem();
					bookItem.id = (count++).toString();
					bookItem.name = item.getTitle();
					bookItem.page = allpages.indexOf(item.findDestinationPage(document))+1;
					bookItem.type = BookmarkItem.CHAPTER;
					items.add(bookItem);
					bookItem.children = getJsonTreeForChild(item,allpages,document);					
					item = item.getNextSibling();
				}
				
				String json = "";
				json+="{ identifier: 'id',\n"+
					  "label: 'name',\n"+
					  "items: [\n";
				for(int i=0;i<items.size();i++){
					BookmarkItem bookItemtem = new BookmarkItem();
					bookItemtem = (BookmarkItem) items.get(i);
					json+="{id : '"+i+"',\n";
					if(bookItemtem.children.size()>0){
						json+="type:'"+bookItemtem.type+"',";
					}else{
						json+="type:'"+bookItemtem.type+"',";
					}
					json+=	  "page : '"+bookItemtem.page+"',\n"+
						  "name: '"+HTMLEntities.forJSON(bookItemtem.name)+"'\n";
					
						  
					if(bookItemtem.children.size()>0){
						json+=",children: [\n";
						for (int j = 0; j < bookItemtem.children.size(); j++) {
							if(j==0)
								json+="{_reference:'"+bookItemtem.children.get(j)+"'}";
							else
								json+=",{_reference:'"+bookItemtem.children.get(j)+"'}";
						}
						json+="]";
					}
					
					if(i==items.size()-1)
						json+="}\n";
					else
						json+="},\n";
					
				}
				json+="]}";
				
				FileWriter sortie = new FileWriter(destination);
				sortie.write(json);
				sortie.close();				
			} catch (Exception e) {
				System.err.println(e);
			} finally {
				if (document != null) {
					document.close();
				}
			}
		}
	}	
	
	private static Vector<BookmarkItem> items = new Vector<BookmarkItem>();
	
	private static Vector<String> getJsonTreeForChild(PDOutlineItem child,ArrayList allPages,PDDocument document) throws IOException, Exception{
		Vector<String> children = new Vector<String>();
		if(child!=null){			
			PDOutlineItem item = child.getFirstChild();			
			while (item != null) {
				String id = (count++).toString();
				BookmarkItem bookItem = new BookmarkItem();
				bookItem.id = id;
				bookItem.name = item.getTitle();
				bookItem.page = allPages.indexOf(item.findDestinationPage(document))+1;
				bookItem.type = BookmarkItem.PAGE;
				items.add(bookItem);
				bookItem.children = getJsonTreeForChild(item, allPages, document);
				children.add(id);				
				item = item.getNextSibling();
			}
		}				
		return children;		
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
}
