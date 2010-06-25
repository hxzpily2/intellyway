package com.bedreamy.base;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import org.apache.pdfbox.exceptions.InvalidPasswordException;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.interactive.documentnavigation.outline.PDDocumentOutline;
import org.apache.pdfbox.pdmodel.interactive.documentnavigation.outline.PDOutlineItem;

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
				List allpages = new ArrayList();
			    document.getDocumentCatalog().getPages().getAllKids(allpages);
				PDDocumentOutline root = document.getDocumentCatalog().getDocumentOutline();
				PDOutlineItem item = root.getFirstChild();
				while (item != null) {
					System.out.println("Item:" + item.getTitle());
					PDOutlineItem child = item.getFirstChild();
					while (child != null) {
						System.out.println("    Child:" + child.getTitle());
						//System.out.println();						
					    int pageNumber = allpages.indexOf(child.findDestinationPage(document))+1;
					    System.out.println(pageNumber);						
						child = child.getNextSibling();
					}
					item = item.getNextSibling();
				}
			} catch (Exception e) {
				System.err.println(e);
			} finally {
				if (document != null) {
					document.close();
				}
			}
		}
	}
	private static String getJsonTreeForChild(PDOutlineItem child,ArrayList allPages){
		if(child!=null){
			return "identifier: 'id'," +
				   "title: 'name',"	+
				   "children: [";
				   
		}else
			return "";
	}
	private static void usage() {
		System.err
				.println("Usage: java com.bedreamy.base.PDFGetBookmarks [OPTIONS] <PDF file>\n"
						+ "  -password  <password>          Password to decrypt document\n"
						+ "  <PDF file>                     The PDF document to use\n");
		System.exit(1);
	}
}
