package com.account.test;

import java.awt.Color;
import java.awt.Font;
import java.awt.FontMetrics;
import java.awt.Graphics2D;
import java.awt.Image;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.security.NoSuchAlgorithmException;
import java.util.Vector;

import javax.imageio.ImageIO;

import com.account.commun.SecuriteGrilleGenerator;

public class LoginTest {
	public static void main(String argv[]) throws IOException, NoSuchAlgorithmException {		
		//updateImageWithGrilleToLogin();
		System.out.println(SecuriteGrilleGenerator.SHA1("12345"));
	}

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
		for (int i = 0; i < 25; i++) {
			System.out.print(tableau[i] + " ");
		}
		return tableau;
	}

	public static void updateImageWithGrilleToLogin() throws IOException {
		int width = 200, height = 200;
		int[] tableau = getGrilleToLogin(); 
		// TYPE_INT_ARGB specifies the image format: 8-bit RGBA packed
		// into integer pixels
		File file = new File("test.gif");
		Image image = ImageIO.read(file);

		BufferedImage bi = bufferImage(image, BufferedImage.TYPE_INT_RGB);

		Graphics2D ig2 = bi.createGraphics();

		Font font = new Font("Tahoma", Font.BOLD, 16);
		ig2.setFont(font);
		
		int PLUS = 26;
		
		FontMetrics fontMetrics = ig2.getFontMetrics();
		ig2.setPaint(Color.WHITE);
		int Ytemp = 0;
		for(int i=0;i<5;i++){
			int Xtemp = 0;			
			for(int j=0;j<5;j++){
				if(tableau[i*5+j]!=0)
					ig2.drawString(new Integer(tableau[i*5+j]).toString(), 8+Xtemp, 18+Ytemp);
				Xtemp+=26;
			}
			Ytemp+=26;
		}		
		
		ImageIO.write(bi, "PNG", new File("c:\\"+System.currentTimeMillis()+".PNG"));			
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
