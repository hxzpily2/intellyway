/*
 * Licensed to the Apache Software Foundation (ASF) under one or more
 * contributor license agreements.  See the NOTICE file distributed with
 * this work for additional information regarding copyright ownership.
 * The ASF licenses this file to You under the Apache License, Version 2.0
 * (the "License"); you may not use this file except in compliance with
 * the License.  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
package com.bedreamy.commun;

import org.apache.pdfbox.exceptions.InvalidPasswordException;


import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.PDPage;
import org.apache.pdfbox.pdmodel.common.PDStream;
import org.apache.pdfbox.util.PDFTextStripper;
import org.apache.pdfbox.util.TextPosition;

import com.bedreamy.model.PDFHighlightingItem;

import java.io.IOException;

import java.util.HashMap;
import java.util.List;
import java.util.Vector;

/**
 * This is an example on how to get some x/y coordinates of text.
 *
 * Usage: java org.apache.pdfbox.examples.util.PrintTextLocations &lt;input-pdf&gt;
 *
 * @author <a href="mailto:ben@benlitchfield.com">Ben Litchfield</a>
 * @version $Revision: 1.7 $
 */
public class PrintTextLocations extends PDFTextStripper
{
    /**
     * Default constructor.
     *
     * @throws IOException If there is an error loading text stripper properties.
     */
	private int compteur = 0;
	private Vector<PDFHighlightingItem> items = new Vector<PDFHighlightingItem>();
	private int page;
	private HashMap<Integer, Vector<PDFHighlightingItem>> map = new HashMap<Integer, Vector<PDFHighlightingItem>>();
	
    public HashMap<Integer, Vector<PDFHighlightingItem>> getMap() {
		return map;
	}

	public void setMap(HashMap<Integer, Vector<PDFHighlightingItem>> map) {
		this.map = map;
	}

	public int getPage() {
		return page;
	}

	public void setPage(int page) {
		this.page = page;
	}

	public Vector<PDFHighlightingItem> getItems() {
		return items;
	}

	public void setItems(Vector<PDFHighlightingItem> items) {
		this.items = items;
	}

	public int getCompteur() {
		return compteur;
	}

	public void setCompteur(int compteur) {
		this.compteur = compteur;
	}

	public PrintTextLocations() throws IOException
    {
        super.setSortByPosition( true );
    }

    /**
     * This will print the documents data.
     *
     * @param args The command line arguments.
     *
     * @throws Exception If there is an error parsing the document.
     */
    public static void main( String[] args ) throws Exception
    {
        if( args.length != 1 )
        {
            usage();
        }
        else
        {
            PDDocument document = null;
            try
            {
                document = PDDocument.load( args[0] );
                if( document.isEncrypted() )
                {
                    try
                    {
                        document.decrypt( "" );
                    }
                    catch( InvalidPasswordException e )
                    {
                        System.err.println( "Error: Document is encrypted with a password." );
                        System.exit( 1 );
                    }
                }
                PrintTextLocations printer = new PrintTextLocations();
                List allPages = document.getDocumentCatalog().getAllPages();
                for( int i=0; i<allPages.size(); i++ )
                {
                    PDPage page = (PDPage)allPages.get( i );
                    System.out.println( "Processing page: " + i );
                    PDStream contents = page.getContents();
                    if( contents != null )
                    {
                        printer.processStream( page, page.findResources(), page.getContents().getStream() );
                    }
                }
            }
            finally
            {
                if( document != null )
                {
                    document.close();
                }
            }
        }
    }

    /**
     * A method provided as an event interface to allow a subclass to perform
     * some specific functionality when text needs to be processed.
     *
     * @param text The text to be processed
     */
    protected void processTextPosition( TextPosition text )
    {
        System.out.println( "String[" + text.getX() + "," +
                text.getY() + " fs=" + text.getFontSize() + " xscale=" +
                text.getXScale() + " yscale="+text.getYScale()+ " height=" + text.getHeightDir() + " space=" +
                text.getWidthOfSpace() + " width=" +
                text.getWidthDirAdj() + " + fontSize="+text.getFontSizeInPt()+"]" + text.getCharacter() );
        this.compteur++;
        Vector<PDFHighlightingItem> temp = map.get(this.page);
        PDFHighlightingItem item = new PDFHighlightingItem();
        item.setFontsize(text.getFontSize());
        item.setHeight(text.getHeight());
        item.setItem(text.getCharacter());
        item.setPage(this.page);
        item.setXscale(text.getXScale());
        item.setYscale(text.getYScale());
        item.setWidth(text.getWidthDirAdj());
        item.setWidthofspace(text.getWidthOfSpace());
        item.setX(text.getXDirAdj());
        item.setY(text.getYDirAdj());
        if(temp==null){
        	temp = new Vector<PDFHighlightingItem>(); 
        	temp.add(item);
        	map.put(this.page,temp);
        }else{
        	temp.add(item);
        	map.put(this.page,temp);
        }
        this.items.add(item);
    }

    /**
     * This will print the usage for this document.
     */
    private static void usage()
    {
        System.err.println( "Usage: java org.apache.pdfbox.examples.pdmodel.PrintTextLocations <input-pdf>" );
    }

}
