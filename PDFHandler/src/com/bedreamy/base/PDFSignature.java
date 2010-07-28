package com.bedreamy.base;



import java.io.ByteArrayInputStream;
import java.io.File;

import org.apache.pdfbox.cos.COSArray;
import org.apache.pdfbox.cos.COSDictionary;
import org.apache.pdfbox.cos.COSName;
import org.apache.pdfbox.pdmodel.PDDocument;

public class PDFSignature {
	public static void main(String[] args) throws Exception {
		PDDocument pdfDocument = PDDocument.load(new File("test.pdf"));
		  try {
		    COSDictionary trailer = pdfDocument.getDocument().getTrailer();
		    COSDictionary root = (COSDictionary) trailer.getDictionaryObject(COSName.ROOT);
		    COSDictionary acroForm = (COSDictionary) root.getDictionaryObject(COSName.getPDFName("AcroForm"));
		    if (null != acroForm) {
		      COSArray fields = (COSArray) acroForm.getDictionaryObject(COSName.getPDFName("Fields"));
		      for (int i = 0; i < fields.size(); i++) {
		        COSDictionary field = (COSDictionary) fields.getObject(i);
		        String type = field.getNameAsString("FT");
		        if ("Sig".equals(type)) {
		          System.out.println(true);
		        }
		      }
		    }
		  } finally {
		    pdfDocument.close();
		  }
		  System.out.println(false);

	}
}
