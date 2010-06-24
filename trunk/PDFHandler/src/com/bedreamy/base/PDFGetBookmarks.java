package com.bedreamy.base;

import java.io.File;
import java.io.IOException;

import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.interactive.documentnavigation.outline.PDDocumentOutline;
import org.apache.pdfbox.pdmodel.interactive.documentnavigation.outline.PDOutlineItem;

public class PDFGetBookmarks {
	public static void main(String[] args) throws IOException {
		
		PDDocument doc = PDDocument.load(new File("test.pdf"));
		PDDocumentOutline root = doc.getDocumentCatalog().getDocumentOutline();
		PDOutlineItem item = root.getFirstChild();
		while (item != null) {
			System.out.println("Item:" + item.getTitle());
			PDOutlineItem child = item.getFirstChild();
			while (child != null) {
				System.out.println("    Child:" + child.getTitle());
				child = child.getNextSibling();
			}
			item = item.getNextSibling();
		}
		
	}
}
