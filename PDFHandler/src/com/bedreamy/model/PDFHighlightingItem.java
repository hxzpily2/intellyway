package com.bedreamy.model;

public class PDFHighlightingItem {
	private int page;
	private float x;
	private float y;
	private float width;
	private float height;
	private float xscale;
	private float yscale;	
	private float fontsize;
	private float widthofspace;
	private String item;
	
	public float getYscale() {
		return yscale;
	}
	public void setYscale(float yscale) {
		this.yscale = yscale;
	}
	public float getXscale() {
		return xscale;
	}
	public void setXscale(float xscale) {
		this.xscale = xscale;
	}
	public int getPage() {
		return page;
	}
	public void setPage(int page) {
		this.page = page;
	}
	public float getX() {
		return x;
	}
	public void setX(float x) {
		this.x = x;
	}
	public float getY() {
		return y;
	}
	public void setY(float y) {
		this.y = y;
	}
	public float getWidth() {
		return width;
	}
	public void setWidth(float width) {
		this.width = width;
	}
	public float getHeight() {
		return height;
	}
	public void setHeight(float height) {
		this.height = height;
	}	
	public float getFontsize() {
		return fontsize;
	}
	public void setFontsize(float fontsize) {
		this.fontsize = fontsize;
	}
	public float getWidthofspace() {
		return widthofspace;
	}
	public void setWidthofspace(float widthofspace) {
		this.widthofspace = widthofspace;
	}
	public String getItem() {
		return item;
	}
	public void setItem(String item) {
		this.item = item;
	}
	
		
}
