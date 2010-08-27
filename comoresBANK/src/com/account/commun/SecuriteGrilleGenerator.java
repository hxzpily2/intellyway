package com.account.commun;

import java.awt.Color;
import java.awt.Font;
import java.awt.FontMetrics;
import java.awt.Graphics2D;
import java.awt.Image;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.util.Vector;

import javax.imageio.ImageIO;

public class SecuriteGrilleGenerator {
	public static int[] getGrilleToLogin() {
		Vector<Integer> keys = new Vector<Integer>();
		Vector<Integer> items = new Vector<Integer>();

		for (int j = 0; j < 10; j++) {
			keys.add(j);
		}

		for (int j = 0; j < 25; j++) {
			items.add(j);
		}

		int tableau[] = new int[25];
		for (int i = 0; i < tableau.length; i++) {
			tableau[i] = 0;
		}

		for (int i = 0; i < 10; i++) {
			int randomK = (int) (Math.random() * (keys.size() - 0)) + 0;
			int itemK = (Integer) keys.get(randomK).intValue();
			keys.remove(randomK);
			int randomI = (int) (Math.random() * (items.size() - 0)) + 0;
			int itemI = (Integer) items.get(randomI).intValue();
			items.remove(randomI);
			tableau[itemI] = itemK;
			// System.out.println(randomK+" "+randomI);
		}		
		return tableau;
	}
	
	public static String updateImageWithGrilleToLogin(int[] tableau,String imageURLIN,String imageURLOUT,long timestamp) throws IOException {
		
		File file = new File(imageURLIN);
		Image image = ImageIO.read(file);

		BufferedImage bi = bufferImage(image, BufferedImage.TYPE_INT_RGB);

		Graphics2D ig2 = bi.createGraphics();

		Font font = new Font("Tahoma", Font.BOLD, 16);
		ig2.setFont(font);
		
		int PLUS = 26;		
		
		ig2.setPaint(Color.WHITE);
		int Ytemp = 0;
		for(int i=0;i<5;i++){
			int Xtemp = 0;			
			for(int j=0;j<5;j++){
				if(tableau[i*5+j]!=0)
					ig2.drawString(new Integer(tableau[i*5+j]).toString(), 8+Xtemp, 18+Ytemp);
				Xtemp+=PLUS;
			}
			Ytemp+=PLUS;
		}		
		
		ImageIO.write(bi, "PNG", new File(imageURLOUT+timestamp+".PNG"));
		return "c:\\"+timestamp+".PNG";
	}

	public static BufferedImage bufferImage(Image image, int type) {
		BufferedImage bufferedImage = new BufferedImage(image.getWidth(null),
				image.getHeight(null), type);
		Graphics2D g = bufferedImage.createGraphics();
		g.drawImage(image, null, null);
		// waitForImage(bufferedImage);
		return bufferedImage;
	}
}
