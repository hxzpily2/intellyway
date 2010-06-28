package com.bedreamy.model;

import java.util.Vector;

public class BookmarkItem {
	public static String PAGE = "page";
	public static String CHAPTER = "chapter";
	
	public String id;
	public String name;
	public String type;
	public Integer page;
	public Vector<String> children;
}
